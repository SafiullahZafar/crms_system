<?php

namespace App\Http\Controllers;

use App\Models\DemoActivity;
use App\Models\DemoRecord;
use App\Models\DemoSession;
use App\Models\DemoVisitor;
use App\Models\ModuleSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DemoController extends Controller
{
    public function enter(Request $request): RedirectResponse
    {
        $token = $request->cookie('demo_session');
        $demoSession = is_string($token) && $token !== ''
            ? DemoSession::query()->where('token_hash', hash('sha256', $token))->whereNull('ended_at')->where('last_seen_at', '>=', now()->subMinutes((int) config('demo.session_timeout_minutes', 30)))->first()
            : null;
        $sessionNeedsCookie = ! $demoSession;
        $visitorToken = $request->cookie('demo_visitor');
        $demoVisitor = is_string($visitorToken) && $visitorToken !== ''
            ? DemoVisitor::query()->where('token_hash', hash('sha256', $visitorToken))->first()
            : null;
        $visitorNeedsCookie = ! is_string($visitorToken) || $visitorToken === '' || ! $demoVisitor;

        if ($demoSession?->visitor) {
            $sessionVisitor = $demoSession->visitor;

            if (! $demoVisitor || $demoVisitor->id !== $sessionVisitor->id || $visitorNeedsCookie) {
                $visitorToken = Str::random(64);
                $sessionVisitor->update(['token_hash' => hash('sha256', $visitorToken)]);
                $demoVisitor = $sessionVisitor;
                $visitorNeedsCookie = true;
            }
        }

        if (! $demoVisitor) {
            $visitorToken = Str::random(64);
            $demoVisitor = DB::transaction(function () use ($visitorToken): DemoVisitor {
                $visitor = DemoVisitor::create(['token_hash' => hash('sha256', $visitorToken)]);
                $this->seedWorkspace($visitor);

                return $visitor;
            });
            $visitorNeedsCookie = true;
        }

        if ($demoVisitor->workspace_seeded_at === null) {
            DB::transaction(function () use ($demoVisitor): void {
                $lockedVisitor = DemoVisitor::query()->lockForUpdate()->findOrFail($demoVisitor->id);

                if ($lockedVisitor->workspace_seeded_at === null) {
                    $this->seedWorkspace($lockedVisitor);
                }
            });
        }

        if ($demoSession && ! $demoSession->demo_visitor_id) {
            $demoSession->update([
                'demo_visitor_id' => $demoVisitor->id,
                'visitor_hash' => $demoVisitor->token_hash,
            ]);
        }

        if ($sessionNeedsCookie) {
            $token = Str::random(64);
            $demoSession = DemoSession::create([
                'demo_visitor_id' => $demoVisitor->id,
                'token_hash' => hash('sha256', $token),
                'visitor_hash' => $demoVisitor->token_hash,
                'browser' => $this->browser($request->userAgent()),
                'platform' => $this->platform($request->userAgent()),
                'started_at' => now(),
                'last_seen_at' => now(),
            ]);
            $this->record($demoSession, 'started', 'dashboard');
        }

        $demoSession->update(['last_seen_at' => now(), 'ended_at' => null]);
        $response = redirect()->route('demo.dashboard');

        if ($sessionNeedsCookie) {
            $response->withCookie(Cookie::make('demo_session', $token, 60 * 24 * 30, httpOnly: true, sameSite: 'lax'));
        }

        if ($visitorNeedsCookie) {
            $response->withCookie(Cookie::make('demo_visitor', $visitorToken, 60 * 24 * 365, httpOnly: true, sameSite: 'lax'));
        }

        return $response;
    }

    public function touchPage(Request $request, string $page): bool
    {
        return $this->recordPageActivity($this->readToken($request), $page);
    }

    public function recordPageActivity(?string $token, string $page): bool
    {
        if ($token === null) {
            return false;
        }

        $demoSession = DemoSession::query()->where('token_hash', hash('sha256', $token))->whereNull('ended_at')->where('last_seen_at', '>=', now()->subMinutes((int) config('demo.session_timeout_minutes', 30)))->first();

        if ($demoSession) {
            $demoSession->update(['last_seen_at' => now()]);
            $this->record($demoSession, 'viewed', $page);

            return true;
        }

        return false;
    }

    public function trackAction(Request $request): Response
    {
        $validated = $request->validate([
            'page' => ['required', 'string', Rule::in(array_keys(ModuleSetting::MODULES))],
            'action' => ['required', 'string', 'max:120'],
        ]);
        $enabledModules = ModuleSetting::enabledFor('demo');

        abort_unless($enabledModules[$validated['page']] ?? false, 404);

        $token = $this->readToken($request);
        abort_if($token === null, 403);

        $demoSession = DemoSession::query()
            ->where('token_hash', hash('sha256', $token))
            ->active()
            ->first();
        abort_if(! $demoSession, 403);

        $action = mb_substr(preg_replace('/\s+/', ' ', trim($validated['action'])) ?? '', 0, 120);

        if ($action === '') {
            return response()->noContent();
        }

        $demoSession->update(['last_seen_at' => now()]);
        DemoActivity::create([
            'demo_session_id' => $demoSession->id,
            'event' => 'action',
            'page' => $validated['page'],
            'action' => $action,
        ]);

        return response()->noContent();
    }

    public function storeRecord(Request $request, string $module): RedirectResponse
    {
        abort_unless(array_key_exists($module, ModuleSetting::MODULES), 404);
        abort_unless(ModuleSetting::enabledFor('demo')[$module] ?? false, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
        $session = $this->activeSession($request);
        $visitor = $session->visitor;
        abort_unless($visitor, 403);

        $visitor->records()->create([
            'module' => $module,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);
        $this->recordAction($session, $module, 'Created a demo record');

        return redirect()->route('demo.'.$module)->with('demo_record_status', 'Demo record created.');
    }

    public function destroyRecord(Request $request, string $module, DemoRecord $record): RedirectResponse
    {
        abort_unless(array_key_exists($module, ModuleSetting::MODULES), 404);
        abort_unless(ModuleSetting::enabledFor('demo')[$module] ?? false, 404);

        $session = $this->activeSession($request);
        abort_unless($record->demo_visitor_id === $session->demo_visitor_id && $record->module === $module, 404);
        $record->delete();
        $this->recordAction($session, $module, 'Deleted a demo record');

        return redirect()->route('demo.'.$module)->with('demo_record_status', 'Demo record deleted.');
    }

    /** @return array{demoMode: bool, demoModule: string, demoRecords: Collection<int, DemoRecord>}|array{} */
    public function recordsFor(Request $request, string $module): array
    {
        if (! $request->routeIs('demo.*')) {
            return [];
        }

        $session = $this->activeSession($request);

        return [
            'demoMode' => true,
            'demoModule' => $module,
            'demoRecords' => $session->visitor?->records()->where('module', $module)->latest()->get() ?? collect(),
        ];
    }

    public function track(Request $request): RedirectResponse
    {
        $token = $this->readToken($request);
        $page = (string) $request->route('page');

        abort_unless(array_key_exists($page, ModuleSetting::MODULES), 404);

        if (! $this->recordPageActivity($token, $page)) {
            return redirect()->route('demo.enter');
        }

        return redirect()->route('demo.'.$page);
    }

    public function dashboard(Request $request): View
    {
        return view('crm.dashboard', $this->recordsFor($request, 'dashboard'));
    }

    public function page(Request $request): View
    {
        $page = str_replace('demo.', '', (string) $request->route()->getName());
        if (! $this->touchPage($request, $page)) {
            return redirect()->route('demo.enter');
        }

        return view('crm.'.$page, ['demoMode' => true]);
    }

    public function showPage(Request $request, string $page): View
    {
        if (! $this->touchPage($request, $page)) {
            return redirect()->route('demo.enter');
        }

        return view('crm.'.$page, ['demoMode' => true]);
    }

    public function exit(Request $request): RedirectResponse
    {
        $token = $this->readToken($request);

        if ($token !== null) {
            $demoSession = DemoSession::query()->where('token_hash', hash('sha256', $token))->whereNull('ended_at')->first();

            if ($demoSession) {
                $demoSession->update(['ended_at' => now(), 'last_seen_at' => now()]);
                $this->record($demoSession, 'ended', null);
            }
        }

        return redirect()->route('login')->withCookie(Cookie::forget('demo_session'));
    }

    private function record(DemoSession $demoSession, string $event, ?string $page): void
    {
        DemoActivity::create(['demo_session_id' => $demoSession->id, 'event' => $event, 'page' => $page]);
    }

    private function recordAction(DemoSession $demoSession, string $page, string $action): void
    {
        DemoActivity::create(['demo_session_id' => $demoSession->id, 'event' => 'action', 'page' => $page, 'action' => $action]);
    }

    private function activeSession(Request $request): DemoSession
    {
        $token = $this->readToken($request);
        abort_if($token === null, 403);

        $session = DemoSession::query()->with('visitor')->where('token_hash', hash('sha256', $token))->active()->first();
        abort_unless($session, 403);

        $session->update(['last_seen_at' => now()]);

        return $session;
    }

    private function seedWorkspace(DemoVisitor $visitor): void
    {
        $entries = [
            'dashboard' => ['New leads', 'Open deals', 'Tasks due', 'Recent activity', 'Team updates', 'Monthly target', 'Pipeline health'],
            'leads' => ['Northstar Analytics', 'Maya Patel', 'Cedar Peak Labs', 'Jordan Lee', 'BrightPath Health', 'Avery Morgan', 'Summit Works'],
            'contacts' => ['Olivia Chen', 'Noah Williams', 'Amara Okafor', 'Ethan Brooks', 'Sofia Martinez', 'Liam Wilson', 'Priya Shah'],
            'companies' => ['Northstar Analytics', 'Cedar Peak Labs', 'BrightPath Health', 'Summit Works', 'Redwood Systems', 'Harborstone Group', 'Atlas Commerce'],
            'deals' => ['Northstar annual plan', 'Cedar Peak expansion', 'BrightPath rollout', 'Summit renewal', 'Redwood pilot', 'Harborstone upgrade', 'Atlas onboarding'],
            'pipeline' => ['Qualification', 'Discovery', 'Solution review', 'Proposal', 'Negotiation', 'Legal review', 'Closed won'],
            'tasks' => ['Follow up with Northstar', 'Prepare discovery brief', 'Send proposal draft', 'Review renewal terms', 'Schedule product demo', 'Update contact notes', 'Confirm next steps'],
            'calendar' => ['Northstar discovery call', 'Product walkthrough', 'Pipeline review', 'BrightPath check-in', 'Team planning', 'Proposal review', 'Quarterly business review'],
            'activities' => ['Sent introduction email', 'Completed discovery call', 'Shared product overview', 'Logged meeting notes', 'Updated opportunity', 'Scheduled follow-up', 'Reviewed proposal'],
            'reports' => ['Lead conversion', 'Revenue forecast', 'Deal velocity', 'Source performance', 'Team activity', 'Win rate trends', 'Pipeline coverage'],
            'automation' => ['New lead assignment', 'Follow-up reminder', 'Deal stage notification', 'Contact enrichment', 'Renewal alert', 'Inactive lead check', 'Won deal handoff'],
            'team' => ['Maya Patel', 'Jordan Lee', 'Avery Morgan', 'Olivia Chen', 'Noah Williams', 'Priya Shah', 'Ethan Brooks'],
            'settings' => ['Workspace profile', 'Lead stages', 'Deal stages', 'Notification rules', 'Email preferences', 'Data fields', 'Access preferences'],
        ];

        foreach ($entries as $module => $titles) {
            foreach ($titles as $index => $title) {
                $visitor->records()->create([
                    'module' => $module,
                    'title' => $title,
                    'description' => 'Private demo sample '.($index + 1).' for '.ModuleSetting::MODULES[$module].'. You can remove it or add your own demo data.',
                ]);
            }
        }

        $visitor->forceFill(['workspace_seeded_at' => now()])->save();
    }

    private function readToken(Request $request): ?string
    {
        $token = $request->cookie('demo_session');

        if (! is_string($token) || $token === '') {
            return null;
        }

        return $token;
    }

    private function browser(?string $userAgent): string
    {
        return match (true) {
            str_contains((string) $userAgent, 'Edg/') => 'Edge',
            str_contains((string) $userAgent, 'Chrome/') => 'Chrome',
            str_contains((string) $userAgent, 'Firefox/') => 'Firefox',
            str_contains((string) $userAgent, 'Safari/') => 'Safari',
            default => 'Other',
        };
    }

    private function platform(?string $userAgent): string
    {
        return match (true) {
            str_contains((string) $userAgent, 'Windows') => 'Windows',
            str_contains((string) $userAgent, 'Mac OS') => 'macOS',
            str_contains((string) $userAgent, 'Android') => 'Android',
            str_contains((string) $userAgent, 'iPhone'), str_contains((string) $userAgent, 'iPad') => 'iOS',
            str_contains((string) $userAgent, 'Linux') => 'Linux',
            default => 'Other',
        };
    }
}

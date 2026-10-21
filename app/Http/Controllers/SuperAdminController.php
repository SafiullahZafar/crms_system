<?php

namespace App\Http\Controllers;

use App\Models\DemoActivity;
use App\Models\DemoSession;
use App\Models\DemoVisitor;
use App\Models\ModuleSetting;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    public function index(): View
    {
        $timeout = (int) config('demo.session_timeout_minutes', 30);
        $sessions = DemoSession::query()
            ->with('visitor')
            ->withCount(['activities as page_views_count' => fn (Builder $query): Builder => $query->where('event', 'viewed')])
            ->latest('last_seen_at')
            ->paginate(25);
        $visitors = DemoVisitor::query()
            ->withCount(['sessions', 'activities as page_views_count' => fn (Builder $query): Builder => $query->where('event', 'viewed')])
            ->withCount(['sessions as active_sessions_count' => fn (Builder $query): Builder => $query->active()])
            ->withMin('sessions', 'started_at')
            ->withMax('sessions', 'last_seen_at')
            ->orderByDesc('sessions_max_last_seen_at')
            ->paginate(25, ['*'], 'visitor_page');
        $activities = DemoActivity::query()->with('demoSession.visitor')->latest('created_at')->paginate(30, ['*'], 'activity_page');
        $uniqueVisitors = DemoVisitor::query()->count();

        return view('admin.dashboard', [
            'activeSessions' => DemoSession::active()->count(),
            'totalSessions' => DemoSession::count(),
            'uniqueVisitors' => $uniqueVisitors,
            'pageViewsToday' => DemoActivity::query()->where('event', 'viewed')->whereDate('created_at', today())->count(),
            'sessions' => $sessions,
            'visitors' => $visitors,
            'activities' => $activities,
            'admins' => User::query()
                ->where('role', 'admin')
                ->where('email', '!=', (string) config('demo.super_admin_email'))
                ->orderBy('name')
                ->get(),
            'timeout' => $timeout,
            'modules' => ModuleSetting::query()->get()->keyBy('module'),
        ]);
    }

    public function showDemoVisitor(DemoVisitor $demoVisitor): View
    {
        $demoVisitor->loadCount([
            'sessions',
            'activities as page_views_count' => fn (Builder $query): Builder => $query->where('event', 'viewed'),
        ]);
        $activeSessions = $demoVisitor->sessions()->active()->count();
        $firstSeenAt = $demoVisitor->sessions()->min('started_at');
        $sessions = $demoVisitor->sessions()
            ->withCount(['activities as page_views_count' => fn (Builder $query): Builder => $query->where('event', 'viewed')])
            ->latest('last_seen_at')
            ->paginate(20, ['*'], 'session_page');
        $activities = $demoVisitor->activities()->with('demoSession')->latest('created_at')->paginate(50, ['*'], 'activity_page');

        return view('admin.demo-visitor', [
            'demoVisitor' => $demoVisitor,
            'firstSeenAt' => $firstSeenAt,
            'activeSessions' => $activeSessions,
            'sessions' => $sessions,
            'activities' => $activities,
        ]);
    }

    public function storeAdmin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'Admin account created.');
    }

    public function updateModules(Request $request): RedirectResponse
    {
        $rules = ['modules' => ['required', 'array']];

        foreach (array_keys(ModuleSetting::MODULES) as $module) {
            $rules['modules.'.$module.'.admin'] = ['required', 'boolean'];
            $rules['modules.'.$module.'.demo'] = ['required', 'boolean'];
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated): void {
            foreach (ModuleSetting::MODULES as $module => $label) {
                ModuleSetting::query()->updateOrCreate(
                    ['module' => $module],
                    [
                        'admin_enabled' => $validated['modules'][$module]['admin'],
                        'demo_enabled' => $validated['modules'][$module]['demo'],
                    ],
                );
            }
        });

        return redirect()->route('admin.dashboard')->with('status', 'Module access updated.');
    }
}

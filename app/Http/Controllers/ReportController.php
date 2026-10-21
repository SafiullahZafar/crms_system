<?php

namespace App\Http\Controllers;

use App\Models\DemoActivity;
use App\Models\DemoSession;
use App\Models\DemoVisitor;
use App\Models\Expense;
use App\Models\ModuleSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function moduleIndex(Request $request): View
    {
        $modules = ModuleSetting::MODULES;
        $enabled = ModuleSetting::enabledFor($request->routeIs('demo.*') ? 'demo' : 'admin');

        if (! $request->routeIs('demo.*') && $request->user()?->isSuperAdmin()) {
            $enabled = array_fill_keys(array_keys($modules), true);
        }

        return view('crm.report-modules', ['modules' => array_filter($modules, fn (string $name): bool => $enabled[$name] ?? false, ARRAY_FILTER_USE_KEY)]);
    }

    public function daily(Request $request): View
    {
        return $this->render($request, 'daily');
    }

    public function monthly(Request $request): View
    {
        return $this->render($request, 'monthly');
    }

    public function tasks(Request $request): View
    {
        return $this->render($request, 'tasks');
    }

    public function activities(Request $request): View
    {
        return $this->render($request, 'activities');
    }

    public function module(Request $request, string $module): View
    {
        abort_unless(array_key_exists($module, ModuleSetting::MODULES), 404);
        abort_unless($this->enabledModules($request)[$module] ?? false, 404);

        return $this->render($request, 'module', $module);
    }

    public function export(Request $request, string $type, ?string $module = null): StreamedResponse
    {
        abort_unless(in_array($type, ['daily', 'monthly', 'tasks', 'activities', 'module'], true), 404);

        if ($type === 'module') {
            abort_unless(is_string($module) && array_key_exists($module, ModuleSetting::MODULES), 404);
        } elseif ($type === 'tasks') {
            $module = 'tasks';
        } elseif ($type === 'activities') {
            $module = 'activities';
        }

        $enabled = $this->enabledModules($request);
        if ($module !== null) {
            abort_unless($enabled[$module] ?? false, 404);
        }

        $rows = $type === 'activities' && $request->routeIs('demo.*')
            ? $this->activityRows($request)
            : $this->reportRows($request, $module);

        if ($type === 'daily') {
            $rows = $rows->filter(fn ($row): bool => $this->rowDate($row)?->isToday() ?? false)->values();
        } elseif ($type === 'monthly') {
            $rows = $rows->filter(fn ($row): bool => $this->rowDate($row)?->isSameMonth(now()) ?? false)->values();
        }

        return response()->streamDownload(function () use ($rows): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Name', 'Module', 'Category', 'Type', 'Date', 'Amount', 'Notes']);

            foreach ($rows as $row) {
                fputcsv($output, [
                    $this->safeCsvValue($row->title ?? ''),
                    $this->safeCsvValue($row->module ?? 'expenses'),
                    $this->safeCsvValue($row->category ?? ''),
                    $this->safeCsvValue($row->type ?? ''),
                    $this->rowDate($row)?->toDateString() ?? '',
                    $row->amount ?? '',
                    $this->safeCsvValue($row->notes ?? $row->description ?? ''),
                ]);
            }

            fclose($output);
        }, 'workspace-report-'.$type.'-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function render(Request $request, string $type, ?string $module = null): View
    {
        $modules = ModuleSetting::MODULES;
        $module = $type === 'tasks' ? 'tasks' : ($type === 'activities' ? 'activities' : $module);
        $enabled = $this->enabledModules($request);
        if ($module !== null) {
            abort_unless($enabled[$module] ?? false, 404);
        }
        $rows = $type === 'activities' && $request->routeIs('demo.*')
            ? $this->activityRows($request)
            : $this->reportRows($request, $module);

        if ($type === 'daily') {
            $rows = $rows->filter(fn ($row): bool => $this->rowDate($row)?->isToday() ?? false)->values();
        } elseif ($type === 'monthly') {
            $rows = $rows->filter(fn ($row): bool => $this->rowDate($row)?->isSameMonth(now()) ?? false)->values();
        }

        $title = match ($type) {
            'daily' => 'Daily report',
            'monthly' => 'Monthly report',
            'tasks' => 'Task report',
            'activities' => 'Activity report',
            default => $modules[$module].' report',
        };

        return view('crm.report-detail', [
            'title' => $title,
            'exportType' => $type,
            'rows' => $rows,
            'module' => $module,
            'isDemo' => $request->routeIs('demo.*'),
            'totalAmount' => $module === 'expenses' || in_array($type, ['daily', 'monthly'], true)
                ? $rows->filter(fn ($row): bool => $row instanceof Expense)->sum('amount')
                : null,
        ]);
    }

    /** @return Collection<int, Model> */
    private function reportRows(Request $request, ?string $module): Collection
    {
        if ($module === 'expenses') {
            return app(ExpenseController::class)->expenseQuery($request)->get();
        }

        $enabled = $this->enabledModules($request);

        if (! $request->routeIs('demo.*')) {
            return $module === null && ($enabled['expenses'] ?? false)
                ? app(ExpenseController::class)->expenseQuery($request)->get()
                : collect();
        }

        $visitor = $this->activeVisitor($request);
        $query = $visitor->records();

        if ($module !== null) {
            $query->where('module', $module);
        } else {
            $query->whereIn('module', array_keys(array_filter($enabled)));
        }

        $records = $query->latest()->get();

        return $module === null && ($enabled['expenses'] ?? false)
            ? $records->concat(app(ExpenseController::class)->expenseQuery($request)->latest('expense_date')->get())
            : $records;
    }

    private function activeVisitor(Request $request): DemoVisitor
    {
        $token = $request->cookie('demo_session');
        abort_unless(is_string($token) && $token !== '', 403);

        $session = DemoSession::query()
            ->with('visitor')
            ->where('token_hash', hash('sha256', $token))
            ->active()
            ->first();

        abort_unless($session?->visitor, 403);
        $session->update(['last_seen_at' => now()]);

        return $session->visitor;
    }

    /** @return Collection<int, DemoActivity> */
    private function activityRows(Request $request): Collection
    {
        $enabledPages = array_keys(array_filter($this->enabledModules($request)));

        return $this->activeVisitor($request)->activities()->whereIn('page', $enabledPages)->latest()->get()->map(function ($activity) {
            $activity->setAttribute('title', $activity->action ?: ucfirst($activity->event));
            $activity->setAttribute('module', $activity->page ?? 'Workspace');

            return $activity;
        });
    }

    private function rowDate(Model $row): ?Carbon
    {
        return $row instanceof Expense ? $row->expense_date : $row->created_at;
    }

    /** @return array<string, bool> */
    private function enabledModules(Request $request): array
    {
        $isDemo = $request->routeIs('demo.*');
        $enabled = ModuleSetting::enabledFor($isDemo ? 'demo' : 'admin');

        if (! $isDemo && $request->user()?->isSuperAdmin()) {
            return array_fill_keys(array_keys(ModuleSetting::MODULES), true);
        }

        return $enabled;
    }

    private function safeCsvValue(mixed $value): string
    {
        $value = (string) $value;

        return preg_match('/^[=+@-]/', $value) === 1 ? "'".$value : $value;
    }
}

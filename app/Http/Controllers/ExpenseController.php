<?php

namespace App\Http\Controllers;

use App\Models\DemoActivity;
use App\Models\DemoSession;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    private const array CATEGORIES = [
        'fixed' => ['Electricity', 'Gas', 'Rent', 'Internet', 'Insurance', 'Software subscription', 'Phone'],
        'variable' => ['Travel', 'Office supplies', 'Meals', 'Marketing', 'Repairs', 'Shipping', 'Other'],
    ];

    public function index(Request $request, DemoController $demoController): View|RedirectResponse
    {
        if ($request->routeIs('demo.*')) {
            if (! $demoController->touchPage($request, 'expenses')) {
                return redirect()->route('demo.enter');
            }
        }

        $expenses = $this->expenseQuery($request)->latest('expense_date')->latest()->get();

        return view('crm.expenses', [
            'isDemo' => $request->routeIs('demo.*'),
            'expenses' => $expenses,
            'fixedTotal' => $expenses->where('type', 'fixed')->sum('amount'),
            'variableTotal' => $expenses->where('type', 'variable')->sum('amount'),
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(array_keys(self::CATEGORIES))],
            'category' => ['required', 'string', Rule::in(array_merge(...array_values(self::CATEGORIES)))],
            'title' => ['required', 'string', 'max:160'],
            'amount' => ['required', 'numeric', 'gt:0', 'max:9999999999.99'],
            'expense_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if (! in_array($validated['category'], self::CATEGORIES[$validated['type']], true)) {
            throw ValidationException::withMessages(['category' => 'Choose a category that matches the expense type.']);
        }

        if ($request->routeIs('demo.*')) {
            $session = $this->activeDemoSession($request);
            $session->visitor->expenses()->create($validated);
            $this->logDemoAction($session, 'Created an expense');
        } else {
            $request->user()->expenses()->create($validated);
        }

        return redirect()->route($request->routeIs('demo.*') ? 'demo.expenses' : 'expenses')
            ->with('status', 'Expense created successfully.');
    }

    public function destroy(Request $request, Expense $expense): RedirectResponse
    {
        if ($request->routeIs('demo.*')) {
            $session = $this->activeDemoSession($request);
            $session->visitor->expenses()->whereKey($expense->id)->firstOrFail()->delete();
            $this->logDemoAction($session, 'Deleted an expense');
        } else {
            $query = Expense::query()->whereKey($expense->id);

            if (! $request->user()->isSuperAdmin()) {
                $query->where('user_id', $request->user()->id);
            }

            $query->firstOrFail()->delete();
        }

        return redirect()->route($request->routeIs('demo.*') ? 'demo.expenses' : 'expenses')
            ->with('status', 'Expense deleted successfully.');
    }

    /** @return Builder<Expense> */
    public function expenseQuery(Request $request): Builder
    {
        if ($request->routeIs('demo.*')) {
            return $this->activeDemoSession($request)->visitor->expenses()->getQuery();
        }

        $query = Expense::query();

        if (! $request->user()->isSuperAdmin()) {
            $query->where('user_id', $request->user()->id);
        }

        return $query;
    }

    private function activeDemoSession(Request $request): DemoSession
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

        return $session;
    }

    private function logDemoAction(DemoSession $session, string $action): void
    {
        DemoActivity::create([
            'demo_session_id' => $session->id,
            'event' => 'action',
            'page' => 'expenses',
            'action' => $action,
        ]);
    }
}

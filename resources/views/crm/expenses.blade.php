@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
<div class="space-y-4 animate-fade-in">
    <div class="glass-card flex flex-wrap items-center justify-between gap-4 p-5">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-800">Finance workspace</p>
            <h1 class="mt-1 text-xl font-extrabold text-[#1b382b]">Expenses</h1>
            <p class="mt-1 text-xs text-[#365b4c]">Track recurring fixed costs and day-to-day variable spending.</p>
        </div>
        <a href="{{ route(($isDemo ? 'demo.' : '').'reports.module', ['module' => 'expenses']) }}" class="rounded-xl border border-emerald-900/15 bg-white/75 px-4 py-2 text-xs font-bold text-emerald-950 hover:bg-white">Expense report</a>
    </div>

    @if (session('status'))
        <div class="glass-card border border-emerald-300 p-3 text-xs font-semibold text-emerald-900">{{ session('status') }}</div>
    @endif

    @if ($isDemo)
        <div class="rounded-xl border border-amber-500/30 bg-amber-100/90 px-4 py-3 text-xs font-semibold text-amber-950">Private demo workspace: these seven starter expenses and any changes belong only to this browser's demo user.</div>
    @endif

    <div class="grid gap-3 sm:grid-cols-3">
        @foreach ([['Fixed expenses', $fixedTotal], ['Variable expenses', $variableTotal], ['Total spending', $fixedTotal + $variableTotal]] as [$label, $amount])
            <div class="glass-card p-4"><p class="text-[10px] font-bold uppercase tracking-wider text-[#365b4c]">{{ $label }}</p><p class="mt-2 text-2xl font-extrabold text-[#1b382b]">${{ number_format($amount, 2) }}</p></div>
        @endforeach
    </div>

    <section class="glass-card p-5">
        <div class="mb-4 border-b border-emerald-900/10 pb-3">
            <h2 class="text-sm font-extrabold text-[#1b382b]">Add an expense</h2>
            <p class="mt-1 text-[11px] text-[#365b4c]">Choose fixed for recurring bills like electricity, gas, rent, and internet; choose variable for changing costs.</p>
        </div>
        <form action="{{ route(($isDemo ? 'demo.' : '').'expenses.store') }}" method="POST" x-data="{ expenseType: '{{ old('type', 'fixed') }}' }" class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
            @csrf
            <label class="text-[10px] font-bold text-[#365b4c]">Expense type
                <select name="type" x-model="expenseType" required class="mt-1 block w-full rounded-xl glass-input px-3 py-2.5 text-xs text-[#1b382b]">
                    <option value="fixed">Fixed expense</option><option value="variable">Variable expense</option>
                </select>
            </label>
            <label class="text-[10px] font-bold text-[#365b4c]">Category
                <template x-if="expenseType === 'fixed'"><select name="category" required class="mt-1 block w-full rounded-xl glass-input px-3 py-2.5 text-xs text-[#1b382b]">@foreach ($categories['fixed'] as $category)<option value="{{ $category }}">{{ $category }}</option>@endforeach</select></template>
                <template x-if="expenseType === 'variable'"><select name="category" required class="mt-1 block w-full rounded-xl glass-input px-3 py-2.5 text-xs text-[#1b382b]">@foreach ($categories['variable'] as $category)<option value="{{ $category }}">{{ $category }}</option>@endforeach</select></template>
            </label>
            <label class="text-[10px] font-bold text-[#365b4c]">Name
                <input name="title" value="{{ old('title') }}" required maxlength="160" placeholder="e.g. Monthly electricity bill" class="mt-1 block w-full rounded-xl glass-input px-3 py-2.5 text-xs text-[#1b382b]">
            </label>
            <label class="text-[10px] font-bold text-[#365b4c]">Amount
                <input name="amount" value="{{ old('amount') }}" type="number" min="0.01" step="0.01" required placeholder="0.00" class="mt-1 block w-full rounded-xl glass-input px-3 py-2.5 text-xs text-[#1b382b]">
            </label>
            <label class="text-[10px] font-bold text-[#365b4c]">Date
                <input name="expense_date" value="{{ old('expense_date', today()->format('Y-m-d')) }}" type="date" required class="mt-1 block w-full rounded-xl glass-input px-3 py-2.5 text-xs text-[#1b382b]">
            </label>
            <label class="text-[10px] font-bold text-[#365b4c]">Notes
                <input name="notes" value="{{ old('notes') }}" maxlength="1000" placeholder="Optional details" class="mt-1 block w-full rounded-xl glass-input px-3 py-2.5 text-xs text-[#1b382b]">
            </label>
            @if ($errors->any())<p class="text-xs font-semibold text-rose-700 sm:col-span-2 xl:col-span-3">{{ $errors->first() }}</p>@endif
            <div class="sm:col-span-2 xl:col-span-3"><button type="submit" class="rounded-xl bg-emerald-800 px-5 py-2.5 text-xs font-bold text-white shadow hover:bg-emerald-950">Create expense</button></div>
        </form>
    </section>

    <section class="glass-card p-5">
        <div class="mb-3 flex flex-wrap items-center justify-between gap-2 border-b border-emerald-900/10 pb-3">
            <div><h2 class="text-sm font-extrabold text-[#1b382b]">Expense ledger</h2><p class="mt-1 text-[10px] text-[#365b4c]">{{ $expenses->count() }} records</p></div>
            <a href="{{ route(($isDemo ? 'demo.' : '').'reports.module', ['module' => 'expenses']) }}" class="text-[10px] font-bold text-emerald-900 hover:underline">View expense report</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[680px] text-left text-xs">
                <thead class="text-[9px] font-bold uppercase tracking-wider text-[#365b4c]"><tr><th class="py-2">Expense</th><th>Type</th><th>Category</th><th>Date</th><th>Amount</th><th></th></tr></thead>
                <tbody>
                    @forelse ($expenses as $expense)
                        <tr class="border-t border-emerald-900/10 text-[#1b382b]">
                            <td class="py-3"><div class="font-bold">{{ $expense->title }}</div>@if ($expense->notes)<div class="mt-0.5 text-[10px] text-[#365b4c]">{{ $expense->notes }}</div>@endif</td>
                            <td><span class="rounded-full px-2 py-1 text-[9px] font-bold {{ $expense->type === 'fixed' ? 'bg-blue-100 text-blue-900' : 'bg-violet-100 text-violet-900' }}">{{ ucfirst($expense->type) }}</span></td>
                            <td>{{ $expense->category }}</td><td>{{ $expense->expense_date->format('M j, Y') }}</td><td class="font-extrabold">${{ number_format((float) $expense->amount, 2) }}</td>
                            <td class="text-right"><form action="{{ route(($isDemo ? 'demo.' : '').'expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Delete this expense?')">@csrf @method('DELETE')<button class="rounded-lg px-2 py-1 text-[10px] font-bold text-rose-700 hover:bg-rose-50">Delete</button></form></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-10 text-center text-[#365b4c]">No expenses recorded yet. Add your first expense above.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

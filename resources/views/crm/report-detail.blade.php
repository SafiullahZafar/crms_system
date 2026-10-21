@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="space-y-4 animate-fade-in">
    <div class="glass-card flex flex-wrap items-center justify-between gap-4 p-5">
        <div><p class="text-[10px] font-bold uppercase tracking-widest text-emerald-800">Reports & analytics</p><h1 class="mt-1 text-xl font-extrabold text-[#1b382b]">{{ $title }}</h1><p class="mt-1 text-xs text-[#365b4c]">Updated from the current workspace data.</p></div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route((request()->routeIs('demo.*') ? 'demo.' : '').'reports.export', ['type' => $exportType, 'module' => $module]) }}" class="rounded-xl bg-emerald-800 px-4 py-2 text-xs font-bold text-white hover:bg-emerald-950">Export CSV</a>
            <a href="{{ route((request()->routeIs('demo.*') ? 'demo.' : '').'reports.modules') }}" class="rounded-xl border border-emerald-900/15 bg-white/75 px-4 py-2 text-xs font-bold text-emerald-950 hover:bg-white">All module reports</a>
        </div>
    </div>
    @if ($isDemo)<div class="rounded-xl border border-amber-500/30 bg-amber-100/90 px-4 py-3 text-xs font-semibold text-amber-950">This report contains only this browser's private demo workspace data.</div>@endif
    <div class="grid gap-3 sm:grid-cols-2">
        <div class="glass-card p-4"><p class="text-[10px] font-bold uppercase tracking-wider text-[#365b4c]">Records in this report</p><p class="mt-2 text-2xl font-extrabold text-[#1b382b]">{{ number_format($rows->count()) }}</p></div>
        @if (! is_null($totalAmount))<div class="glass-card p-4"><p class="text-[10px] font-bold uppercase tracking-wider text-[#365b4c]">Expense total</p><p class="mt-2 text-2xl font-extrabold text-[#1b382b]">${{ number_format((float) $totalAmount, 2) }}</p></div>@endif
    </div>
    <section class="glass-card p-5">
        <h2 class="mb-3 text-sm font-extrabold text-[#1b382b]">Report details</h2>
        <div class="overflow-x-auto"><table class="w-full min-w-[540px] text-left text-xs">
            <thead class="text-[9px] font-bold uppercase tracking-wider text-[#365b4c]"><tr><th class="py-2">Name</th><th>Category / module</th><th>Date</th>@if (! is_null($totalAmount))<th>Amount</th>@endif</tr></thead>
            <tbody>
                @forelse ($rows as $row)
                    <tr class="border-t border-emerald-900/10 text-[#1b382b]"><td class="py-3 font-bold">{{ $row->title }}</td><td>{{ $row->category ?? \Illuminate\Support\Str::headline($row->module ?? '') }}</td><td>{{ ($row->expense_date ?? $row->created_at)?->format('M j, Y') ?? '—' }}</td>@if (! is_null($totalAmount))<td class="font-extrabold">{{ $row instanceof \App\Models\Expense ? '$'.number_format((float) $row->amount, 2) : '—' }}</td>@endif</tr>
                @empty
                    <tr><td colspan="{{ is_null($totalAmount) ? 3 : 4 }}" class="py-10 text-center text-[#365b4c]">There is no matching data for this report yet.</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </section>
</div>
@endsection

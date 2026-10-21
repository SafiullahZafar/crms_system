@extends('layouts.app')

@section('title', 'Module reports')

@section('content')
<div class="space-y-4 animate-fade-in">
    <div class="glass-card p-5">
        <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-800">Reports & analytics</p>
        <h1 class="mt-1 text-xl font-extrabold text-[#1b382b]">Module reports</h1>
        <p class="mt-1 text-xs text-[#365b4c]">Choose a workspace module to review its available records and totals.</p>
    </div>
    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($modules as $module => $label)
            <a href="{{ route((request()->routeIs('demo.*') ? 'demo.' : '').'reports.module', ['module' => $module]) }}" class="glass-card group p-4 hover:-translate-y-0.5 hover:bg-white/90">
                <div class="flex items-center justify-between"><h2 class="text-sm font-extrabold text-[#1b382b]">{{ $label }}</h2><span class="text-emerald-800 transition-transform group-hover:translate-x-1">→</span></div>
                <p class="mt-2 text-[11px] text-[#365b4c]">Open the {{ strtolower($label) }} report and review its current data.</p>
            </a>
        @endforeach
    </div>
</div>
@endsection

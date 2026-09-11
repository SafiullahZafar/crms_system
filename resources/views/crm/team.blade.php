@extends('layouts.app')

@section('title', 'Team Management')

@section('content')
<div class="space-y-4 animate-fade-in">

    {{-- PAGE HEADER --}}
    <div class="glass-card kpi-accent-teal p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Team & User Management
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#58967d]/15 text-[#366050] font-bold border border-[#58967d]/20">12 Active Reps</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Manage team roles, lead allocation limits, quota permissions — powered by BrosTech.</p>
        </div>
        <button class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md flex items-center gap-2 hover:brightness-110 active:scale-95 transition-all flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Invite Teammate
        </button>
    </div>

    {{-- TEAM STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        @php
            $teamStats = [
                ['label' => 'Total Members', 'value' => '12', 'color' => 'kpi-accent-emerald'],
                ['label' => 'Revenue MTD', 'value' => '$86.2K', 'color' => 'kpi-accent-teal'],
                ['label' => 'Avg Deal Count', 'value' => '14.3', 'color' => 'kpi-accent-blue'],
                ['label' => 'Quota Attained', 'value' => '86.2%', 'color' => 'kpi-accent-purple'],
            ];
        @endphp
        @foreach($teamStats as $stat)
        <div class="glass-card {{ $stat['color'] }} p-4">
            <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">{{ $stat['label'] }}</div>
            <div class="text-2xl font-extrabold text-[#1b382b] mt-1">{{ $stat['value'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- TEAM CARDS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
            $members = [
                ['name' => 'Olivia Carter', 'role' => 'Sales Director', 'email' => 'olivia.carter@nexoracrm.com', 'leads' => 14, 'revenue' => '$480,000', 'quota' => 91, 'status' => 'Active', 'status_class' => 'badge-won', 'role_badge' => 'Admin', 'role_bg' => 'bg-[#2c4d41] text-white', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=256'],
                ['name' => 'Michael Lee', 'role' => 'Senior Account Exec', 'email' => 'michael.l@nexoracrm.com', 'leads' => 18, 'revenue' => '$340,000', 'quota' => 78, 'status' => 'Active', 'status_class' => 'badge-won', 'role_badge' => 'Account Exec', 'role_bg' => 'bg-[#58967d]/15 text-[#366050]', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256'],
                ['name' => 'Sarah Kim', 'role' => 'Account Manager', 'email' => 'sarah.k@nexoracrm.com', 'leads' => 11, 'revenue' => '$195,000', 'quota' => 65, 'status' => 'Active', 'status_class' => 'badge-won', 'role_badge' => 'Manager', 'role_bg' => 'bg-teal-500/15 text-teal-800', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=256'],
                ['name' => 'Daniel Park', 'role' => 'Business Dev Rep', 'email' => 'daniel.p@nexoracrm.com', 'leads' => 22, 'revenue' => '$124,000', 'quota' => 54, 'status' => 'Active', 'status_class' => 'badge-won', 'role_badge' => 'BDR', 'role_bg' => 'bg-blue-500/15 text-blue-700', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256'],
                ['name' => 'Lisa Chang', 'role' => 'Sales Development Rep', 'email' => 'lisa.c@nexoracrm.com', 'leads' => 31, 'revenue' => '$82,500', 'quota' => 42, 'status' => 'Active', 'status_class' => 'badge-won', 'role_badge' => 'SDR', 'role_bg' => 'bg-purple-500/15 text-purple-700', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=256'],
                ['name' => 'James Wright', 'role' => 'Enterprise Account Exec', 'email' => 'james.w@nexoracrm.com', 'leads' => 6, 'revenue' => '$290,000', 'quota' => 88, 'status' => 'On Leave', 'status_class' => 'badge-pending', 'role_badge' => 'Account Exec', 'role_bg' => 'bg-[#58967d]/15 text-[#366050]', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256'],
            ];
        @endphp
        @foreach($members as $member)
        <div class="glass-card glass-card-hover p-5 flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative flex-shrink-0">
                        <img class="w-11 h-11 rounded-xl object-cover ring-2 ring-white/60"
                             src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}">
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 {{ $member['status'] === 'Active' ? 'bg-emerald-500' : 'bg-amber-500' }} border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <div class="font-extrabold text-sm text-[#1b382b]">{{ $member['name'] }}</div>
                        <div class="text-[10px] text-[#427863]">{{ $member['role'] }}</div>
                    </div>
                </div>
                <span class="px-2 py-0.5 rounded-full {{ $member['role_bg'] }} font-extrabold text-[10px]">{{ $member['role_badge'] }}</span>
            </div>

            <div class="space-y-1.5 text-xs border-t border-white/30 pt-3">
                <div class="flex justify-between"><span class="text-[#427863]">Email:</span> <span class="font-medium text-[#1b382b]">{{ $member['email'] }}</span></div>
                <div class="flex justify-between"><span class="text-[#427863]">Active Leads:</span> <span class="font-bold text-[#1b382b]">{{ $member['leads'] }} leads</span></div>
                <div class="flex justify-between"><span class="text-[#427863]">Closed Revenue:</span> <span class="font-extrabold text-[#58967d]">{{ $member['revenue'] }}</span></div>
            </div>

            <div class="border-t border-white/30 pt-3">
                <div class="flex justify-between text-xs mb-1.5">
                    <span class="text-[#427863] font-medium">Quota Attainment</span>
                    <span class="font-extrabold text-[#1b382b]">{{ $member['quota'] }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $member['quota'] }}%;"></div>
                </div>
            </div>

            <div class="flex gap-2 border-t border-white/30 pt-3">
                <button class="flex-1 py-2 rounded-xl glass-pill text-[11px] font-bold text-[#2c4d41] hover:bg-white/40 transition-colors">Edit Role</button>
                <span class="px-2 py-2 rounded-xl {{ $member['status_class'] }} font-bold text-[10px] flex items-center">{{ $member['status'] }}</span>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection

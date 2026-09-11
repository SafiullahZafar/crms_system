@extends('layouts.app')

@section('title', 'Activities Log')

@section('content')
<div class="space-y-4 animate-fade-in">

    {{-- PAGE HEADER --}}
    <div class="glass-card kpi-accent-teal p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Activities & Interaction Log
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-teal-500/15 text-teal-800 font-bold border border-teal-500/20">18 Today</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Full audit trail of CRM interactions, calls, emails, and deal stage movements.</p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <select class="px-3 py-1.5 text-xs font-semibold rounded-xl glass-input text-[#1b382b]">
                <option>All Types</option>
                <option>Calls</option>
                <option>Emails</option>
                <option>Meetings</option>
                <option>Deal Stages</option>
            </select>
            <select class="px-3 py-1.5 text-xs font-semibold rounded-xl glass-input text-[#1b382b]">
                <option>All Team Members</option>
                <option>Olivia Carter</option>
                <option>Michael Lee</option>
                <option>Sarah Kim</option>
            </select>
        </div>
    </div>

    {{-- ACTIVITY STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        @php
            $actStats = [['label' => 'Calls Logged', 'value' => '7', 'c' => 'kpi-accent-emerald'], ['label' => 'Emails Sent', 'value' => '4', 'c' => 'kpi-accent-blue'], ['label' => 'Meetings Held', 'value' => '7', 'c' => 'kpi-accent-purple'], ['label' => 'Stage Moves', 'value' => '3', 'c' => 'kpi-accent-amber']];
        @endphp
        @foreach($actStats as $s)
        <div class="glass-card {{ $s['c'] }} p-4 text-center">
            <div class="text-2xl font-extrabold text-[#1b382b]">{{ $s['value'] }}</div>
            <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider mt-1">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ACTIVITY FEED --}}
    <div class="glass-card overflow-hidden">
        <div class="p-5 border-b border-white/30">
            <h3 class="font-extrabold text-sm text-[#1b382b]">Full Activity Timeline</h3>
            <p class="text-[10px] text-[#427863] mt-0.5">All CRM events, sorted by most recent</p>
        </div>
        <div class="divide-y divide-white/20">
            @php
                $activities = [
                    ['actor' => 'Michael Lee', 'action' => 'viewed proposal for Horizon Robotics', 'time' => '2m ago', 'type' => 'View', 'color' => 'bg-emerald-500/15 text-emerald-800', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                    ['actor' => 'Sarah Kim', 'action' => 'added new contact — Sophia Chen at EcoCloud', 'time' => '18m ago', 'type' => 'Contact', 'color' => 'bg-blue-500/15 text-blue-800', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=64'],
                    ['actor' => 'Acme Corporation', 'action' => 'deal moved from Proposal → Negotiation stage', 'time' => '1h ago', 'type' => 'Deal Stage', 'color' => 'bg-amber-500/15 text-amber-800', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                    ['actor' => 'Daniel Park', 'action' => 'logged a 24-minute call with GreenTech CEO', 'time' => '3h ago', 'type' => 'Call', 'color' => 'bg-teal-500/15 text-teal-800', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                    ['actor' => 'GreenTech Solutions', 'action' => 'new deal created — Solar Fleet Monitoring License', 'time' => '5h ago', 'type' => 'Deal Created', 'color' => 'bg-[#58967d]/15 text-[#366050]', 'icon' => 'M12 4v16m8-8H4', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                    ['actor' => 'Olivia Carter', 'action' => 'sent signed contract PDF to Acme Corp', 'time' => 'Yesterday, 4:30 PM', 'type' => 'Email', 'color' => 'bg-purple-500/15 text-purple-800', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                    ['actor' => 'Marcus Brody', 'action' => 'scheduled product demo for Sep 15', 'time' => 'Yesterday, 2:00 PM', 'type' => 'Meeting', 'color' => 'bg-rose-500/15 text-rose-800', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                    ['actor' => 'Vanguard Capital', 'action' => 'lead status updated — moved to Qualified', 'time' => 'Sep 9, 11:00 AM', 'type' => 'Lead Update', 'color' => 'bg-blue-500/15 text-blue-800', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                ];
            @endphp
            @foreach($activities as $act)
            <div class="flex items-center justify-between px-5 py-3.5 hover:bg-white/20 transition-colors">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-8 h-8 rounded-xl {{ $act['color'] }} flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $act['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs">
                            <span class="font-bold text-[#1b382b]">{{ $act['actor'] }}</span>
                            <span class="text-[#427863]"> {{ $act['action'] }}</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded glass-pill font-bold text-[#366050] mt-1 inline-block">{{ $act['type'] }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                    <img class="w-6 h-6 rounded-full object-cover ring-1 ring-white/60"
                         src="{{ $act['avatar'] }}" alt="User">
                    <span class="text-[10px] text-[#58967d] font-semibold whitespace-nowrap">{{ $act['time'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

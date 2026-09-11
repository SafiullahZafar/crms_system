@extends('layouts.app')

@section('title', 'Sales Automation')

@section('content')
<div class="space-y-4 animate-fade-in">

    {{-- PAGE HEADER --}}
    <div class="glass-card kpi-accent-purple p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Sales Automation Workflows
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#58967d]/15 text-[#366050] font-bold border border-[#58967d]/20">6 Active Recipes</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Automate welcome email sequences, lead routing, and deal inactivity alerts — powered by BrosTech.</p>
        </div>
        <button class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md flex items-center gap-2 hover:brightness-110 active:scale-95 transition-all flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Workflow
        </button>
    </div>

    {{-- AUTOMATION STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        @php
            $autoStats = [
                ['label' => 'Active Workflows', 'value' => '6', 'sub' => '2 paused', 'color' => 'kpi-accent-emerald'],
                ['label' => 'Emails Sent', 'value' => '1,842', 'sub' => 'This month', 'color' => 'kpi-accent-blue'],
                ['label' => 'Leads Routed', 'value' => '284', 'sub' => 'Auto-assigned', 'color' => 'kpi-accent-teal'],
                ['label' => 'Time Saved', 'value' => '48h', 'sub' => 'This quarter', 'color' => 'kpi-accent-purple'],
            ];
        @endphp
        @foreach($autoStats as $stat)
        <div class="glass-card {{ $stat['color'] }} p-4">
            <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">{{ $stat['label'] }}</div>
            <div class="text-2xl font-extrabold text-[#1b382b] mt-1">{{ $stat['value'] }}</div>
            <div class="text-[10px] text-[#427863] mt-0.5">{{ $stat['sub'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- WORKFLOW CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @php
            $workflows = [
                ['icon' => '⚡', 'icon_bg' => 'bg-[#58967d]/15 text-[#366050]', 'title' => 'Inbound Lead Auto-Assignment', 'desc' => 'Triggers when new demo request is received', 'trigger' => 'Form Submitted ("Website Demo")', 'action' => 'Round-robin assign to Senior AEs + Send Slack alert', 'runs' => '142 runs', 'active' => true, 'border' => 'kpi-accent-emerald'],
                ['icon' => '✉️', 'icon_bg' => 'bg-teal-500/15 text-teal-800', 'title' => 'Drip Campaign: Post-Proposal Follow-up', 'desc' => 'Automated email touchpoints after proposal sent', 'trigger' => 'Deal moved to "Proposal" stage', 'action' => 'Send Day 3 & Day 7 check-in email sequence', 'runs' => '89 runs', 'active' => true, 'border' => 'kpi-accent-teal'],
                ['icon' => '🔔', 'icon_bg' => 'bg-amber-500/15 text-amber-800', 'title' => 'Deal Inactivity Alert', 'desc' => 'Notifies rep when deal is stale for 7+ days', 'trigger' => 'No activity on deal for 7 days', 'action' => 'Send Slack DM + create follow-up task for AE', 'runs' => '31 runs', 'active' => true, 'border' => 'kpi-accent-amber'],
                ['icon' => '🎉', 'icon_bg' => 'bg-emerald-500/15 text-emerald-800', 'title' => 'Win Celebration & Onboarding Kickoff', 'desc' => 'Kicks off customer onboarding when deal is closed', 'trigger' => 'Deal stage changed to "Won"', 'action' => 'Send welcome email + notify CS team + create onboarding tasks', 'runs' => '28 runs', 'active' => true, 'border' => 'kpi-accent-emerald'],
                ['icon' => '📊', 'icon_bg' => 'bg-purple-500/15 text-purple-800', 'title' => 'Weekly Pipeline Report Email', 'desc' => 'Automated executive summary every Monday 8AM', 'trigger' => 'Scheduled: Every Monday at 8:00 AM', 'action' => 'Generate PDF report + email to Sales Director + team leads', 'runs' => '12 runs', 'active' => true, 'border' => 'kpi-accent-purple'],
                ['icon' => '⚠️', 'icon_bg' => 'bg-rose-500/15 text-rose-800', 'title' => 'At-Risk Customer Health Check', 'desc' => 'Monitors customer health score drops', 'trigger' => 'Customer health score drops below 70%', 'action' => 'Alert Account Manager + schedule check-in call', 'runs' => '8 runs', 'active' => false, 'border' => 'kpi-accent-rose'],
            ];
        @endphp
        @foreach($workflows as $wf)
        <div class="glass-card {{ $wf['border'] }} p-5 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl {{ $wf['icon_bg'] }} flex items-center justify-center text-lg flex-shrink-0">
                        {{ $wf['icon'] }}
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm text-[#1b382b]">{{ $wf['title'] }}</h3>
                        <p class="text-[10px] text-[#427863] mt-0.5">{{ $wf['desc'] }} &bull; <span class="text-[#58967d] font-semibold">{{ $wf['runs'] }}</span></p>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="text-[10px] font-bold {{ $wf['active'] ? 'text-emerald-700' : 'text-[#427863]' }}">{{ $wf['active'] ? 'Active' : 'Paused' }}</span>
                    <input type="checkbox" {{ $wf['active'] ? 'checked' : '' }}
                           class="w-5 h-5 rounded text-[#58967d] focus:ring-[#58967d] border-[#58967d]/40">
                </div>
            </div>
            <div class="p-3 rounded-xl glass-row text-xs space-y-2">
                <div class="flex items-start gap-2">
                    <span class="font-bold text-[#58967d] flex-shrink-0">Trigger:</span>
                    <span class="text-[#1b382b]">{{ $wf['trigger'] }}</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="font-bold text-amber-700 flex-shrink-0">Action:</span>
                    <span class="text-[#1b382b]">{{ $wf['action'] }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="text-[11px] font-bold text-[#58967d] hover:underline">Edit Workflow</button>
                <span class="text-[#427863]">&bull;</span>
                <button class="text-[11px] font-bold text-[#427863] hover:underline">View Logs</button>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection

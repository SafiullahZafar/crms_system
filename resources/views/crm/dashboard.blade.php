@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-4 animate-fade-in" x-data="{ activeTab: 'overview' }">

    {{-- ══════════════════════════════════════
         WELCOME BANNER
    ══════════════════════════════════════ --}}
    <div class="glass-card kpi-accent-emerald p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Good morning, Olivia <span class="animate-bounce inline-block">👋</span>
            </h1>
            <p class="text-xs text-[#427863] mt-1 font-medium">
                Here's your real-time CRM intelligence report &mdash; <span class="text-[#58967d] font-bold">Q3 is on track</span> with 28% revenue growth.
            </p>
            <div class="flex items-center gap-3 mt-2">
                <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-500/20 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse inline-block"></span>
                    Live Data
                </span>
                <span class="text-[10px] text-[#427863] font-medium">Mon, Sep 10, 2026 &bull; Q3 Sales Quarter</span>
            </div>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            <div class="text-right hidden sm:block glass-row p-3 rounded-xl">
                <div class="text-[11px] font-bold text-[#427863] uppercase tracking-wider">Monthly Target</div>
                <div class="text-lg font-extrabold text-[#1b382b]">86.2%</div>
                <div class="progress-track w-28 mt-1">
                    <div class="progress-fill" style="width: 86.2%;"></div>
                </div>
            </div>
            <button @click="quickModalOpen = true"
                    class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#2c4d41] text-white text-xs font-bold shadow-md shadow-[#366050]/20 hover:brightness-110 active:scale-95 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Quick Lead
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         8 KPI CARDS
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

        {{-- Total Leads --}}
        <div class="glass-card glass-card-hover kpi-accent-emerald p-4 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="w-9 h-9 rounded-xl bg-[#58967d]/15 flex items-center justify-center text-[#366050]">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-500/20">↑ 12%</span>
            </div>
            <div class="mt-3">
                <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">Total Leads</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-0.5">1,284</div>
                <div class="text-[10px] text-[#58967d] mt-1 font-medium">+142 new this month</div>
            </div>
        </div>

        {{-- Revenue Won --}}
        <div class="glass-card glass-card-hover kpi-accent-emerald p-4 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/15 flex items-center justify-center text-emerald-800">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-500/20">↑ 28%</span>
            </div>
            <div class="mt-3">
                <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">Revenue Won</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-0.5">$86,240</div>
                <div class="text-[10px] text-emerald-700 mt-1 font-medium">vs $67,300 prev month</div>
            </div>
        </div>

        {{-- Active Customers --}}
        <div class="glass-card glass-card-hover kpi-accent-emerald p-4 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="w-9 h-9 rounded-xl bg-[#58967d]/15 flex items-center justify-center text-[#366050]">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11"/></svg>
                </div>
                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-500/20">↑ 8%</span>
            </div>
            <div class="mt-3">
                <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">Active Customers</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-0.5">482</div>
                <div class="text-[10px] text-[#58967d] mt-1 font-medium">98.4% retention rate</div>
            </div>
        </div>

        {{-- Open Tasks --}}
        <div class="glass-card glass-card-hover kpi-accent-rose p-4 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="w-9 h-9 rounded-xl bg-rose-500/15 flex items-center justify-center text-rose-800">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded-full bg-rose-500/15 text-rose-800 border border-rose-500/20">↓ 14%</span>
            </div>
            <div class="mt-3">
                <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">Open Tasks</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-0.5">24</div>
                <div class="text-[10px] text-[#427863] mt-1 font-medium">5 high priority due today</div>
            </div>
        </div>

        {{-- Conversion Rate --}}
        <div class="glass-card glass-card-hover kpi-accent-emerald p-4 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/15 flex items-center justify-center text-emerald-800">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-500/20">↑ 4.2%</span>
            </div>
            <div class="mt-3">
                <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">Conversion Rate</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-0.5">18.4%</div>
                <div class="text-[10px] text-[#58967d] mt-1 font-medium">Lead → customer pipeline</div>
            </div>
        </div>

        {{-- Pipeline Value --}}
        <div class="glass-card glass-card-hover kpi-accent-emerald p-4 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/15 flex items-center justify-center text-emerald-800">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-500/20">↑ 19%</span>
            </div>
            <div class="mt-3">
                <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">Pipeline Value</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-0.5">$412K</div>
                <div class="text-[10px] text-[#58967d] mt-1 font-medium">32 active opportunities</div>
            </div>
        </div>

        {{-- Avg Deal Size --}}
        <div class="glass-card glass-card-hover kpi-accent-emerald p-4 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="w-9 h-9 rounded-xl bg-[#58967d]/15 flex items-center justify-center text-[#366050]">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/></svg>
                </div>
                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-500/20">↑ 6%</span>
            </div>
            <div class="mt-3">
                <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">Avg. Deal Size</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-0.5">$12,890</div>
                <div class="text-[10px] text-[#58967d] mt-1 font-medium">Up from $12,160</div>
            </div>
        </div>

        {{-- Activities Today --}}
        <div class="glass-card glass-card-hover kpi-accent-emerald p-4 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="w-9 h-9 rounded-xl bg-[#58967d]/15 flex items-center justify-center text-[#366050]">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-500/20">Today</span>
            </div>
            <div class="mt-3">
                <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">Activities Today</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-0.5">18</div>
                <div class="text-[10px] text-[#427863] mt-1 font-medium">7 calls &bull; 4 emails &bull; 7 meetings</div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         CHARTS ROW — PIPELINE + TREND
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

        {{-- Sales Pipeline Bar Chart (5 cols) --}}
        <div class="lg:col-span-5 glass-card p-5 flex flex-col">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-4">
                <div>
                    <h3 class="font-extrabold text-sm text-[#1b382b]">Sales Pipeline</h3>
                    <p class="text-[10px] text-[#427863]">Stage distribution & conversion rates</p>
                </div>
                <a href="{{ route('pipeline') }}" class="text-[11px] font-bold text-[#58967d] hover:underline flex items-center gap-1">
                    View All →
                </a>
            </div>
            <div class="grid grid-cols-5 gap-2 text-center items-end h-44 flex-1">
                @php
                    $stages = [
                        ['label' => 'New', 'count' => 230, 'pct' => '35%', 'h' => '85%', 'from' => 'from-[#58967d]', 'to' => 'to-[#7eb39b]'],
                        ['label' => 'Qual.', 'count' => 164, 'pct' => '25%', 'h' => '65%', 'from' => 'from-[#427863]', 'to' => 'to-[#58967d]'],
                        ['label' => 'Prop.', 'count' => 98, 'pct' => '18%', 'h' => '45%', 'from' => 'from-[#366050]', 'to' => 'to-[#427863]'],
                        ['label' => 'Nego.', 'count' => 54, 'pct' => '12%', 'h' => '32%', 'from' => 'from-[#2c4d41]', 'to' => 'to-[#366050]'],
                        ['label' => 'Won', 'count' => 32, 'pct' => '10%', 'h' => '22%', 'from' => 'from-emerald-700', 'to' => 'to-emerald-500'],
                    ];
                @endphp
                @foreach($stages as $stage)
                <div class="flex flex-col items-center h-full justify-end group">
                    <span class="text-[10px] font-bold text-[#1b382b] mb-1">{{ $stage['count'] }}</span>
                    <div class="w-full bg-gradient-to-t {{ $stage['from'] }} {{ $stage['to'] }} rounded-t-xl transition-all duration-300 group-hover:brightness-110 shadow-sm"
                         style="height: {{ $stage['h'] }};"></div>
                    <span class="text-[10px] font-bold text-[#2c4d41] mt-1.5">{{ $stage['label'] }}</span>
                    <span class="text-[9px] text-[#427863] font-semibold">{{ $stage['pct'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Revenue Trend (7 cols) --}}
        <div class="lg:col-span-7 glass-card p-5 flex flex-col">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-4">
                <div>
                    <h3 class="font-extrabold text-sm text-[#1b382b]">Revenue Trend</h3>
                    <p class="text-[10px] text-[#427863]">Monthly growth over 6 months</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-[#1b382b] px-2 py-1 rounded-xl glass-pill">$86,240 <span class="text-emerald-700">+28%</span></span>
                    <select class="text-[11px] font-semibold text-[#2c4d41] glass-input rounded-xl px-2 py-1 border border-white/40">
                        <option>This Year</option>
                        <option>Last Year</option>
                    </select>
                </div>
            </div>
            <div class="relative flex-1 min-h-[160px]">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         MIDDLE ROW — TOP DEALS + RECENT LEADS
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

        {{-- Top Deals Report List (6 cols) --}}
        <div class="lg:col-span-6 glass-card p-5 flex flex-col">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-3">
                <div>
                    <h3 class="font-extrabold text-sm text-[#1b382b]">Top Deals Report</h3>
                    <p class="text-[10px] text-[#427863]">Highest-value active opportunities</p>
                </div>
                <a href="{{ route('deals') }}" class="text-[11px] font-bold text-[#58967d] hover:underline">View All →</a>
            </div>
            <div class="space-y-2 flex-1">
                @php
                    $topDeals = [
                        ['name' => 'Vanguard Capital', 'contact' => 'David Miller', 'value' => '$180,000', 'stage' => 'Negotiation', 'stage_class' => 'badge-negotiation', 'prob' => 75, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'Horizon Robotics', 'contact' => 'Marcus Brody', 'value' => '$120,000', 'stage' => 'Proposal', 'stage_class' => 'badge-proposal', 'prob' => 55, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'Apex Logistics', 'contact' => 'Sarah Kim', 'value' => '$95,000', 'stage' => 'Qualified', 'stage_class' => 'badge-qualified', 'prob' => 40, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'EcoCloud Systems', 'contact' => 'Sophia Chen', 'value' => '$68,500', 'stage' => 'Proposal', 'stage_class' => 'badge-proposal', 'prob' => 60, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'Acme Corporation', 'contact' => 'Eleanor Vance', 'value' => '$45,000', 'stage' => 'Won', 'stage_class' => 'badge-won', 'prob' => 100, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                    ];
                @endphp
                @foreach($topDeals as $deal)
                <div class="flex items-center gap-3 p-2.5 rounded-xl glass-row group cursor-pointer">
                    <img class="w-8 h-8 rounded-lg object-cover flex-shrink-0 ring-1 ring-white/60"
                         src="{{ $deal['avatar'] }}" alt="{{ $deal['contact'] }}">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-bold text-[#1b382b] truncate">{{ $deal['name'] }}</span>
                            <span class="text-xs font-extrabold text-[#1b382b] flex-shrink-0">{{ $deal['value'] }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-2 mt-1">
                            <span class="text-[10px] text-[#427863]">{{ $deal['contact'] }}</span>
                            <span class="px-1.5 py-0.5 rounded-full {{ $deal['stage_class'] }} font-bold text-[9px]">{{ $deal['stage'] }}</span>
                        </div>
                        <div class="progress-track mt-1.5">
                            <div class="progress-fill" style="width: {{ $deal['prob'] }}%;"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Leads List (6 cols) --}}
        <div class="lg:col-span-6 glass-card p-5 flex flex-col">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-3">
                <div>
                    <h3 class="font-extrabold text-sm text-[#1b382b]">Recent Leads</h3>
                    <p class="text-[10px] text-[#427863]">Latest inbound pipeline entries</p>
                </div>
                <a href="{{ route('leads') }}" class="text-[11px] font-bold text-[#58967d] hover:underline">View All →</a>
            </div>
            <div class="space-y-2 flex-1">
                @php
                    $recentLeads = [
                        ['name' => 'Eleanor Vance', 'company' => 'Apex Global Logistics', 'source' => 'Website', 'status' => 'Qualified', 'status_class' => 'badge-qualified', 'time' => '9:30 AM', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'Marcus Brody', 'company' => 'Horizon Robotics', 'source' => 'LinkedIn', 'status' => 'Proposal', 'status_class' => 'badge-proposal', 'time' => 'Yesterday', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'Sophia Chen', 'company' => 'EcoCloud Systems', 'source' => 'Referral', 'status' => 'New Lead', 'status_class' => 'badge-new', 'time' => '3h ago', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'David Miller', 'company' => 'Vanguard Capital', 'source' => 'Cold Email', 'status' => 'Negotiation', 'status_class' => 'badge-negotiation', 'time' => 'Sep 8', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'James Carter', 'company' => 'BlueSky Finance', 'source' => 'Event', 'status' => 'New Lead', 'status_class' => 'badge-new', 'time' => 'Sep 7', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                    ];
                @endphp
                @foreach($recentLeads as $lead)
                <div class="flex items-center gap-3 p-2.5 rounded-xl glass-row group cursor-pointer">
                    <img class="w-8 h-8 rounded-lg object-cover flex-shrink-0 ring-1 ring-white/60"
                         src="{{ $lead['avatar'] }}" alt="{{ $lead['name'] }}">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-bold text-[#1b382b] truncate">{{ $lead['name'] }}</span>
                            <span class="px-1.5 py-0.5 rounded-full {{ $lead['status_class'] }} font-bold text-[9px] flex-shrink-0">{{ $lead['status'] }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-2 mt-0.5">
                            <span class="text-[10px] text-[#427863] truncate">{{ $lead['company'] }} &bull; {{ $lead['source'] }}</span>
                            <span class="text-[10px] text-[#58967d] font-semibold flex-shrink-0">{{ $lead['time'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         BOTTOM ROW — TASKS + CUSTOMERS PIE + ACTIVITY FEED
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

        {{-- Upcoming Tasks (4 cols) --}}
        <div class="lg:col-span-4 glass-card p-5 flex flex-col">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-3">
                <h3 class="font-extrabold text-sm text-[#1b382b]">Upcoming Tasks</h3>
                <a href="{{ route('tasks') }}" class="text-[11px] font-bold text-[#58967d] hover:underline">View All →</a>
            </div>
            <div class="space-y-2 flex-1">
                @php
                    $tasks = [
                        ['title' => 'Follow up with Acme Corp', 'time' => 'Today, 10:00 AM', 'priority' => 'high', 'done' => false, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                        ['title' => 'Send proposal to GreenTech', 'time' => 'Today, 2:00 PM', 'priority' => 'high', 'done' => false, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                        ['title' => 'Prepare demo for Horizon Ltd', 'time' => 'Tomorrow, 11:00 AM', 'priority' => 'medium', 'done' => false, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=64'],
                        ['title' => 'Call with Jane Smith (Lead)', 'time' => 'Sep 12, 9:30 AM', 'priority' => 'low', 'done' => true, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                    ];
                @endphp
                @foreach($tasks as $task)
                <div class="flex items-center justify-between p-2.5 rounded-xl glass-row hover:bg-white/30 transition-all">
                    <div class="flex items-center gap-3 min-w-0">
                        <input type="checkbox" {{ $task['done'] ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-[#58967d] border-emerald-300 focus:ring-[#58967d] flex-shrink-0">
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-[#1b382b] {{ $task['done'] ? 'line-through opacity-50' : '' }} truncate">{{ $task['title'] }}</div>
                            <div class="text-[10px] {{ $task['priority'] === 'high' ? 'text-rose-600' : 'text-[#427863]' }} font-medium">{{ $task['time'] }}</div>
                        </div>
                    </div>
                    <img class="w-6 h-6 rounded-full ring-1 ring-[#58967d]/30 flex-shrink-0"
                         src="{{ $task['avatar'] }}" alt="Avatar">
                </div>
                @endforeach
            </div>
        </div>

        {{-- Customer Segments Donut (4 cols) --}}
        <div class="lg:col-span-4 glass-card p-5 flex flex-col">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-3">
                <h3 class="font-extrabold text-sm text-[#1b382b]">Customer Segments</h3>
                <span class="text-[11px] font-bold text-[#58967d] px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20">482 Total</span>
            </div>
            <div class="flex items-center justify-center relative h-36 my-1">
                <canvas id="customersDonutChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-xl font-extrabold text-[#1b382b]">482</span>
                    <span class="text-[10px] text-[#427863] font-semibold">Customers</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs pt-3 border-t border-white/30">
                @php
                    $segments = [
                        ['label' => 'Active', 'pct' => '78%', 'color' => 'bg-[#58967d]'],
                        ['label' => 'Onboarding', 'pct' => '12%', 'color' => 'bg-[#7eb39b]'],
                        ['label' => 'At Risk', 'pct' => '6%', 'color' => 'bg-amber-500'],
                        ['label' => 'Churned', 'pct' => '4%', 'color' => 'bg-rose-500'],
                    ];
                @endphp
                @foreach($segments as $seg)
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ $seg['color'] }} flex-shrink-0"></span>
                    <span class="text-[#1b382b] font-medium truncate">{{ $seg['label'] }}: <b class="font-bold">{{ $seg['pct'] }}</b></span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Live Activity Feed (4 cols) --}}
        <div class="lg:col-span-4 glass-card p-5 flex flex-col">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-3">
                <h3 class="font-extrabold text-sm text-[#1b382b]">Live Activity Feed</h3>
                <a href="{{ route('activities') }}" class="text-[11px] font-bold text-[#58967d] hover:underline">View All →</a>
            </div>
            <div class="space-y-1 flex-1">
                @php
                    $activities = [
                        ['actor' => 'Michael Lee', 'action' => 'viewed proposal', 'time' => '2m ago', 'color' => 'bg-emerald-500/15 text-emerald-800', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
                        ['actor' => 'Sarah Kim', 'action' => 'added new contact', 'time' => '18m ago', 'color' => 'bg-blue-500/15 text-blue-800', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
                        ['actor' => 'Acme Corp', 'action' => 'moved to Negotiation', 'time' => '1h ago', 'color' => 'bg-amber-500/15 text-amber-800', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
                        ['actor' => 'Daniel Park', 'action' => 'logged a call', 'time' => '3h ago', 'color' => 'bg-teal-500/15 text-teal-800', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                        ['actor' => 'GreenTech', 'action' => 'new deal created', 'time' => '5h ago', 'color' => 'bg-[#58967d]/15 text-[#366050]', 'icon' => 'M12 4v16m8-8H4'],
                        ['actor' => 'Olivia Carter', 'action' => 'sent contract PDF', 'time' => 'Yesterday', 'color' => 'bg-purple-500/15 text-purple-800', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ];
                @endphp
                @foreach($activities as $act)
                <div class="flex items-center justify-between p-2 rounded-xl hover:bg-white/25 transition-colors">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-7 h-7 rounded-lg {{ $act['color'] }} flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $act['icon'] }}"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-[#1b382b]">{{ $act['actor'] }}</span>
                            <span class="text-[11px] text-[#427863]"> {{ $act['action'] }}</span>
                        </div>
                    </div>
                    <span class="text-[10px] text-[#58967d] font-semibold flex-shrink-0 ml-2">{{ $act['time'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         REPORTS ROW — TEAM PERFORMANCE + LEAD SOURCES + TOP COMPANIES
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

        {{-- Team Performance Table (5 cols) --}}
        <div class="lg:col-span-5 glass-card p-5">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-3">
                <div>
                    <h3 class="font-extrabold text-sm text-[#1b382b]">Team Performance</h3>
                    <p class="text-[10px] text-[#427863]">Sep 2026 leaderboard</p>
                </div>
                <a href="{{ route('team') }}" class="text-[11px] font-bold text-[#58967d] hover:underline">View Team →</a>
            </div>
            <div class="space-y-3">
                @php
                    $team = [
                        ['name' => 'Olivia Carter', 'role' => 'Sales Director', 'deals' => 12, 'revenue' => '$42K', 'rate' => '91%', 'bar' => 91, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'Michael Lee', 'role' => 'Senior AE', 'deals' => 9, 'revenue' => '$28K', 'rate' => '78%', 'bar' => 78, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                        ['name' => 'Sarah Kim', 'role' => 'Account Manager', 'deals' => 7, 'revenue' => '$16K', 'rate' => '65%', 'bar' => 65, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=64'],
                    ];
                @endphp
                @foreach($team as $i => $member)
                <div class="flex items-center gap-3 p-2.5 rounded-xl glass-row">
                    <div class="text-[11px] font-extrabold text-[#427863] w-5 flex-shrink-0 text-center">{{ $i + 1 }}</div>
                    <img class="w-8 h-8 rounded-lg object-cover flex-shrink-0 ring-1 ring-white/60"
                         src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-[#1b382b]">{{ $member['name'] }}</span>
                            <span class="text-xs font-extrabold text-[#58967d]">{{ $member['revenue'] }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-0.5">
                            <span class="text-[10px] text-[#427863]">{{ $member['deals'] }} deals closed</span>
                            <span class="text-[10px] text-[#427863]">{{ $member['rate'] }}</span>
                        </div>
                        <div class="progress-track mt-1">
                            <div class="progress-fill" style="width: {{ $member['bar'] }}%;"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Lead Sources Donut (3 cols) --}}
        <div class="lg:col-span-3 glass-card p-5">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-3">
                <h3 class="font-extrabold text-sm text-[#1b382b]">Lead Sources</h3>
            </div>
            <div class="h-36 relative mb-3">
                <canvas id="leadSourceMiniChart"></canvas>
            </div>
            <div class="space-y-1.5 text-xs">
                @php
                    $sources = [
                        ['label' => 'Website Inbound', 'pct' => '42%', 'color' => 'bg-[#58967d]'],
                        ['label' => 'LinkedIn Outbound', 'pct' => '24%', 'color' => 'bg-[#366050]'],
                        ['label' => 'Partner Referral', 'pct' => '18%', 'color' => 'bg-[#7eb39b]'],
                        ['label' => 'Events & Expos', 'pct' => '10%', 'color' => 'bg-amber-500'],
                        ['label' => 'Cold Email', 'pct' => '6%', 'color' => 'bg-blue-500'],
                    ];
                @endphp
                @foreach($sources as $src)
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full {{ $src['color'] }} flex-shrink-0"></span>
                        <span class="text-[#427863] truncate">{{ $src['label'] }}</span>
                    </span>
                    <span class="font-bold text-[#1b382b]">{{ $src['pct'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Top Companies (4 cols) --}}
        <div class="lg:col-span-4 glass-card p-5">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-3">
                <div>
                    <h3 class="font-extrabold text-sm text-[#1b382b]">Top Companies</h3>
                    <p class="text-[10px] text-[#427863]">By revenue potential</p>
                </div>
                <a href="{{ route('companies') }}" class="text-[11px] font-bold text-[#58967d] hover:underline">View All →</a>
            </div>
            <div class="space-y-2">
                @php
                    $companies = [
                        ['name' => 'Apex Global Logistics', 'industry' => 'Supply Chain', 'revenue' => '$890K', 'health' => 94, 'initials' => 'AG', 'from' => 'from-teal-700', 'to' => 'to-slate-800'],
                        ['name' => 'Vanguard Capital', 'industry' => 'Finance', 'revenue' => '$720K', 'health' => 88, 'initials' => 'VC', 'from' => 'from-blue-700', 'to' => 'to-blue-900'],
                        ['name' => 'Acme Corporation', 'industry' => 'Software & SaaS', 'revenue' => '$450K', 'health' => 96, 'initials' => 'AC', 'from' => 'from-[#58967d]', 'to' => 'to-[#2c4d41]'],
                        ['name' => 'GreenTech Solutions', 'industry' => 'Green Energy', 'revenue' => '$220K', 'health' => 82, 'initials' => 'GT', 'from' => 'from-emerald-600', 'to' => 'to-teal-800'],
                    ];
                @endphp
                @foreach($companies as $co)
                <div class="flex items-center gap-3 p-2.5 rounded-xl glass-row group cursor-pointer">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br {{ $co['from'] }} {{ $co['to'] }} flex items-center justify-center text-white font-bold text-[10px] flex-shrink-0 shadow-sm">
                        {{ $co['initials'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-[#1b382b] truncate">{{ $co['name'] }}</span>
                            <span class="text-xs font-extrabold text-[#58967d] flex-shrink-0">{{ $co['revenue'] }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-0.5">
                            <span class="text-[10px] text-[#427863]">{{ $co['industry'] }}</span>
                            <span class="text-[10px] text-emerald-700 font-bold">{{ $co['health'] }}% health</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

{{-- ══════════════════════════════════════
     CHART.JS INITIALIZATION
══════════════════════════════════════ --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    // 1. Revenue Trend Line Chart
    const ctxTrend = document.getElementById('salesTrendChart')?.getContext('2d');
    if (ctxTrend) {
        const gradient = ctxTrend.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(88, 150, 125, 0.50)');
        gradient.addColorStop(1, 'rgba(88, 150, 125, 0.0)');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [25000, 38000, 32000, 54000, 62000, 86240],
                    borderColor: '#427863',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradient,
                    pointBackgroundColor: '#2c4d41',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(27, 56, 43, 0.92)',
                        padding: 10, titleFont: { size: 11, weight: 'bold' },
                        bodyFont: { size: 11 }, displayColors: false,
                        callbacks: { label: ctx => 'Revenue: $' + ctx.raw.toLocaleString() }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10, weight: '600' }, color: '#427863' } },
                    y: {
                        grid: { color: 'rgba(200, 220, 210, 0.25)' },
                        ticks: { font: { size: 10, weight: '600' }, color: '#427863', callback: v => '$' + (v / 1000) + 'k' }
                    }
                }
            }
        });
    }

    // 2. Customers Donut
    const ctxDonut = document.getElementById('customersDonutChart')?.getContext('2d');
    if (ctxDonut) {
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Onboarding', 'At Risk', 'Churned'],
                datasets: [{
                    data: [376, 58, 29, 19],
                    backgroundColor: ['#10b981', '#58967d', '#366050', '#ef4444'],
                    borderWidth: 3,
                    borderColor: 'rgba(255,255,255,0.6)',
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '74%',
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: 'rgba(27,56,43,0.9)', titleFont: { size: 11, weight: 'bold' } }
                }
            }
        });
    }

    // 3. Lead Sources Pie
    const ctxSrc = document.getElementById('leadSourceMiniChart')?.getContext('2d');
    if (ctxSrc) {
        new Chart(ctxSrc, {
            type: 'doughnut',
            data: {
                labels: ['Website', 'LinkedIn', 'Referral', 'Events', 'Cold Email'],
                datasets: [{
                    data: [42, 24, 18, 10, 6],
                    backgroundColor: ['#10b981', '#58967d', '#366050', '#7eb39b', '#2c4d41'],
                    borderWidth: 2,
                    borderColor: 'rgba(255,255,255,0.5)',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '60%',
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: 'rgba(27,56,43,0.9)' }
                }
            }
        });
    }

});
</script>
@endsection

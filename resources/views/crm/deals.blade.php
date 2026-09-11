@extends('layouts.app')

@section('title', 'Deals & Opportunities')

@section('content')
<div class="space-y-4 animate-fade-in">

    {{-- PAGE HEADER --}}
    <div class="glass-card kpi-accent-emerald p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Deals & Opportunities
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#58967d]/15 text-[#366050] font-bold border border-[#58967d]/20">$1.4M Pipeline</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Track active contract negotiations, stage probabilities, and close date forecasts.</p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('pipeline') }}" class="px-3.5 py-2 rounded-xl glass-pill text-xs font-bold text-[#2c4d41] hover:bg-white/40 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Kanban View
            </a>
            <button @click="quickModalOpen = true"
                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md hover:brightness-110 active:scale-95 transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Deal
            </button>
        </div>
    </div>

    {{-- SUMMARY FORECAST CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="glass-card kpi-accent-emerald p-4 flex items-center justify-between">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-[#427863]">Total Pipeline Value</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-1">$1,420,500</div>
                <div class="text-[10px] text-[#58967d] font-semibold mt-0.5">Across 28 open deals</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#58967d]/15 flex items-center justify-center text-[#366050]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
        <div class="glass-card kpi-accent-teal p-4 flex items-center justify-between">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-[#427863]">Weighted Forecast</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-1">$914,800</div>
                <div class="text-[10px] text-emerald-700 font-semibold mt-0.5">64.4% win probability</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-teal-500/15 flex items-center justify-center text-teal-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="glass-card kpi-accent-blue p-4 flex items-center justify-between">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-[#427863]">Average Deal Size</div>
                <div class="text-2xl font-extrabold text-[#1b382b] mt-1">$50,732</div>
                <div class="text-[10px] text-[#58967d] font-semibold mt-0.5">+14.2% vs last quarter</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center text-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a2 2 0 012-2z"/></svg>
            </div>
        </div>
    </div>

    {{-- DEALS TABLE --}}
    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs glass-table">
                <thead>
                    <tr class="text-[#427863] font-bold uppercase text-[10px] tracking-wider">
                        <th class="py-3 px-4">Deal Title</th>
                        <th class="py-3 px-4">Company</th>
                        <th class="py-3 px-4">Owner</th>
                        <th class="py-3 px-4 text-center">Stage</th>
                        <th class="py-3 px-4 text-right">Value</th>
                        <th class="py-3 px-4">Win Probability</th>
                        <th class="py-3 px-4">Close Date</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-[#1b382b]">
                    @php
                        $deals = [
                            ['title' => 'Global Enterprise ERP Expansion', 'company' => 'Acme Corporation', 'owner' => 'Olivia Carter', 'stage' => 'Negotiation', 'stage_class' => 'badge-negotiation', 'value' => '$180,000', 'prob' => 85, 'close' => 'Sep 30, 2026', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                            ['title' => 'Solar Fleet Monitoring License', 'company' => 'GreenTech Solutions', 'owner' => 'Michael Lee', 'stage' => 'Proposal Sent', 'stage_class' => 'badge-proposal', 'value' => '$120,000', 'prob' => 60, 'close' => 'Oct 15, 2026', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                            ['title' => 'AI-Powered Routing Intelligence Suite', 'company' => 'Apex Global Logistics', 'owner' => 'Sarah Kim', 'stage' => 'Qualified', 'stage_class' => 'badge-qualified', 'value' => '$95,000', 'prob' => 40, 'close' => 'Nov 1, 2026', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=64'],
                            ['title' => 'Cloud Migration & DevOps Platform', 'company' => 'Horizon Robotics', 'owner' => 'Michael Lee', 'stage' => 'Proposal Sent', 'stage_class' => 'badge-proposal', 'value' => '$68,500', 'prob' => 55, 'close' => 'Oct 28, 2026', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                            ['title' => 'Financial Data Analytics Dashboard', 'company' => 'Vanguard Capital', 'owner' => 'Olivia Carter', 'stage' => 'Negotiation', 'stage_class' => 'badge-negotiation', 'value' => '$145,000', 'prob' => 78, 'close' => 'Sep 22, 2026', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                            ['title' => 'SMB Starter CRM Package', 'company' => 'EcoCloud Systems', 'owner' => 'Sarah Kim', 'stage' => 'Won', 'stage_class' => 'badge-won', 'value' => '$42,500', 'prob' => 100, 'close' => 'Sep 10, 2026', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=64'],
                        ];
                    @endphp
                    @foreach($deals as $deal)
                    <tr class="cursor-pointer">
                        <td class="py-3 px-4 font-extrabold text-[#1b382b]">{{ $deal['title'] }}</td>
                        <td class="py-3 px-4 font-semibold text-[#427863]">{{ $deal['company'] }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <img class="w-5 h-5 rounded-full object-cover" src="{{ $deal['avatar'] }}" alt="{{ $deal['owner'] }}">
                                <span class="font-medium">{{ $deal['owner'] }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2 py-0.5 rounded-full {{ $deal['stage_class'] }} font-extrabold text-[10px]">{{ $deal['stage'] }}</span>
                        </td>
                        <td class="py-3 px-4 text-right font-extrabold text-[#1b382b]">{{ $deal['value'] }}</td>
                        <td class="py-3 px-4">
                            <div class="progress-track w-20">
                                <div class="progress-fill" style="width: {{ $deal['prob'] }}%;"></div>
                            </div>
                            <span class="text-[10px] text-[#427863] font-bold mt-0.5 block">{{ $deal['prob'] }}%</span>
                        </td>
                        <td class="py-3 px-4 text-[#427863] font-medium">{{ $deal['close'] }}</td>
                        <td class="py-3 px-4 text-right">
                            <button class="text-[11px] font-bold text-[#58967d] hover:underline">Edit →</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

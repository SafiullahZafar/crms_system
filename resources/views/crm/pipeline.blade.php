@extends('layouts.app')

@section('title', 'Sales Pipeline Board')

@section('content')
<div class="space-y-6">

    <!-- PAGE HEADER & PIPELINE STATS -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 glass-card p-5">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Sales Pipeline Board
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#58967d]/15 text-[#366050] font-bold border border-[#58967d]/20">7 Stages</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Drag & drop deals across stages to advance deals through your sales funnel.</p>
        </div>

        <div class="flex items-center gap-4 text-xs">
            <div class="glass-pill px-3 py-1.5 rounded-xl">
                <span class="text-[#427863] font-medium">Pipeline Value:</span> <b class="text-[#1b382b] font-extrabold">$1.4M</b>
            </div>
            <div class="glass-pill px-3 py-1.5 rounded-xl">
                <span class="text-[#427863] font-medium">Won This Month:</span> <b class="text-emerald-700 font-extrabold">$182,400</b>
            </div>
            <div class="glass-pill px-3 py-1.5 rounded-xl">
                <span class="text-[#427863] font-medium">Win Rate:</span> <b class="text-[#58967d] font-extrabold">68%</b>
            </div>
            <button @click="quickModalOpen = true" class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md">
                + Add Deal
            </button>
        </div>
    </div>

    <!-- 7-COLUMN KANBAN BOARD BOARD -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-3 overflow-x-auto pb-6">
        
        <!-- Column 1: New -->
        <div class="glass-card p-3 flex flex-col gap-3 min-w-[220px]">
            <div class="flex items-center justify-between pb-2 border-b border-white/50">
                <span class="font-extrabold text-xs text-[#1b382b]">New</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-new">$142k (4)</span>
            </div>
            <div class="space-y-3">
                <div class="glass-card glass-card-hover p-3">
                    <div class="text-xs font-bold text-[#1b382b]">EcoCloud Systems</div>
                    <div class="text-[10px] text-[#427863]">Sophia Chen</div>
                    <div class="mt-2.5 flex items-center justify-between">
                        <span class="font-extrabold text-xs text-[#1b382b]">$42,500</span>
                        <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 2: Contacted -->
        <div class="glass-card p-3 flex flex-col gap-3 min-w-[220px]">
            <div class="flex items-center justify-between pb-2 border-b border-white/50">
                <span class="font-extrabold text-xs text-[#1b382b]">Contacted</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-pending">$85k (3)</span>
            </div>
            <div class="space-y-3">
                <div class="glass-card glass-card-hover p-3">
                    <div class="text-xs font-bold text-[#1b382b]">Nexus Financial</div>
                    <div class="text-[10px] text-[#427863]">Alex Mercer</div>
                    <div class="mt-2.5 flex items-center justify-between">
                        <span class="font-extrabold text-xs text-[#1b382b]">$85,000</span>
                        <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 3: Qualified -->
        <div class="glass-card p-3 flex flex-col gap-3 min-w-[220px]">
            <div class="flex items-center justify-between pb-2 border-b border-white/50">
                <span class="font-extrabold text-xs text-[#1b382b]">Qualified</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-qualified">$195k (5)</span>
            </div>
            <div class="space-y-3">
                <div class="glass-card glass-card-hover p-3">
                    <div class="text-xs font-bold text-[#1b382b]">Apex Logistics</div>
                    <div class="text-[10px] text-[#427863]">Eleanor Vance</div>
                    <div class="mt-2.5 flex items-center justify-between">
                        <span class="font-extrabold text-xs text-[#1b382b]">$65,000</span>
                        <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 4: Proposal -->
        <div class="glass-card p-3 flex flex-col gap-3 min-w-[220px]">
            <div class="flex items-center justify-between pb-2 border-b border-white/50">
                <span class="font-extrabold text-xs text-[#1b382b]">Proposal</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-proposal">$260k (4)</span>
            </div>
            <div class="space-y-3">
                <div class="glass-card glass-card-hover p-3">
                    <div class="text-xs font-bold text-[#1b382b]">GreenTech Solutions</div>
                    <div class="text-[10px] text-[#427863]">Marcus Brody</div>
                    <div class="mt-2.5 flex items-center justify-between">
                        <span class="font-extrabold text-xs text-[#1b382b]">$120,000</span>
                        <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 5: Negotiation -->
        <div class="glass-card p-3 flex flex-col gap-3 min-w-[220px]">
            <div class="flex items-center justify-between pb-2 border-b border-white/50">
                <span class="font-extrabold text-xs text-[#1b382b]">Negotiation</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-negotiation">$380k (3)</span>
            </div>
            <div class="space-y-3">
                <div class="glass-card glass-card-hover p-3">
                    <div class="text-xs font-bold text-[#1b382b]">Acme Corporation</div>
                    <div class="text-[10px] text-[#427863]">David Miller</div>
                    <div class="mt-2.5 flex items-center justify-between">
                        <span class="font-extrabold text-xs text-[#1b382b]">$180,000</span>
                        <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 6: Won -->
        <div class="glass-card p-3 flex flex-col gap-3 min-w-[220px]">
            <div class="flex items-center justify-between pb-2 border-b border-white/50">
                <span class="font-extrabold text-xs text-[#1b382b]">Won</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-won">$182k (5)</span>
            </div>
            <div class="space-y-3">
                <div class="glass-card glass-card-hover p-3 border-emerald-500/30">
                    <div class="text-xs font-bold text-[#1b382b]">Starlight Labs</div>
                    <div class="text-[10px] text-emerald-800 font-semibold">Contract Signed</div>
                    <div class="mt-2.5 flex items-center justify-between">
                        <span class="font-extrabold text-xs text-emerald-700">$95,000</span>
                        <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 7: Lost -->
        <div class="glass-card p-3 flex flex-col gap-3 min-w-[220px]">
            <div class="flex items-center justify-between pb-2 border-b border-white/50">
                <span class="font-extrabold text-xs text-[#1b382b]">Lost</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-lost">$40k (1)</span>
            </div>
            <div class="space-y-3">
                <div class="glass-card p-3 opacity-60">
                    <div class="text-xs font-bold text-[#1b382b]">Omni Tech</div>
                    <div class="text-[10px] text-rose-700">Budget Cut</div>
                    <div class="mt-2.5 flex items-center justify-between">
                        <span class="font-extrabold text-xs text-[#1b382b]">$40,000</span>
                        <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

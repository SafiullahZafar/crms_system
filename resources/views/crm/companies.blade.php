@extends('layouts.app')

@section('title', 'Companies Directory')

@section('content')
<div class="space-y-4 animate-fade-in" x-data="{ selectedCompany: null }">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 glass-card kpi-accent-blue p-5">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Companies Directory
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#58967d]/15 text-[#366050] font-bold border border-[#58967d]/20">142 Accounts</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Manage enterprise client organizations, industry segments, and account health scores.</p>
        </div>

        <div class="flex items-center gap-2">
            <button @click="quickModalOpen = true" class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md shadow-[#366050]/20 hover:brightness-110 active:scale-95 transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Company</span>
            </button>
        </div>
    </div>

    <!-- SEARCH & FILTER ROW -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 glass-card p-3">
        <input type="text" placeholder="Search company by name or industry..." class="px-3.5 py-2 text-xs font-medium rounded-xl glass-input text-[#1b382b]">
        
        <select class="px-3.5 py-2 text-xs font-semibold rounded-xl glass-input text-[#1b382b]">
            <option>Industry: All</option>
            <option>Software & SaaS</option>
            <option>Logistics & Supply</option>
            <option>Financial Services</option>
            <option>Green Energy</option>
        </select>

        <select class="px-3.5 py-2 text-xs font-semibold rounded-xl glass-input text-[#1b382b]">
            <option>Relationship Health: All</option>
            <option>High Health (90%+)</option>
            <option>Stable (70%-89%)</option>
            <option>At Risk (&lt;70%)</option>
        </select>
    </div>

    <!-- COMPANIES GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        
        <!-- Company Card 1 -->
        <div class="glass-card glass-card-hover p-5 flex flex-col justify-between cursor-pointer" @click="selectedCompany = { name: 'Acme Corporation', industry: 'Software & SaaS', employees: '1,200+', revenue: '$450,000', manager: 'Olivia Carter', health: '96% High', openDeals: 3 }">
            <div>
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#58967d] to-[#2c4d41] flex items-center justify-center text-white font-extrabold text-lg shadow-md border border-white/50">
                        AC
                    </div>
                    <span class="px-2.5 py-1 rounded-full badge-won font-extrabold text-[10px]">96% Health</span>
                </div>
                <h3 class="text-base font-extrabold text-[#1b382b] mt-3">Acme Corporation</h3>
                <p class="text-xs text-[#427863] font-semibold">Software & SaaS &bull; Enterprise</p>
                
                <div class="mt-4 pt-3 border-t border-white/50 space-y-1.5 text-xs">
                    <div class="flex justify-between"><span class="text-[#427863]">Employees:</span> <b class="text-[#1b382b]">1,200+</b></div>
                    <div class="flex justify-between"><span class="text-[#427863]">Revenue Potential:</span> <b class="text-[#58967d] font-extrabold">$450,000</b></div>
                    <div class="flex justify-between"><span class="text-[#427863]">Open Opportunities:</span> <b class="text-emerald-800 font-bold">3 Active Deals</b></div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-white/50 flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=256" alt="Rep">
                    <span class="text-[#427863] font-medium">Olivia Carter</span>
                </div>
                <span class="text-[#58967d] font-bold">View Profile →</span>
            </div>
        </div>

        <!-- Company Card 2 -->
        <div class="glass-card glass-card-hover p-5 flex flex-col justify-between cursor-pointer" @click="selectedCompany = { name: 'GreenTech Solutions', industry: 'Green Energy', employees: '450', revenue: '$220,000', manager: 'Michael Lee', health: '88% Healthy', openDeals: 2 }">
            <div>
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-800 flex items-center justify-center text-white font-extrabold text-lg shadow-md border border-white/50">
                        GT
                    </div>
                    <span class="px-2.5 py-1 rounded-full badge-qualified font-extrabold text-[10px]">88% Health</span>
                </div>
                <h3 class="text-base font-extrabold text-[#1b382b] mt-3">GreenTech Solutions</h3>
                <p class="text-xs text-[#427863] font-semibold">Green Energy &bull; Mid-Market</p>
                
                <div class="mt-4 pt-3 border-t border-white/50 space-y-1.5 text-xs">
                    <div class="flex justify-between"><span class="text-[#427863]">Employees:</span> <b class="text-[#1b382b]">450</b></div>
                    <div class="flex justify-between"><span class="text-[#427863]">Revenue Potential:</span> <b class="text-[#58967d] font-extrabold">$220,000</b></div>
                    <div class="flex justify-between"><span class="text-[#427863]">Open Opportunities:</span> <b class="text-emerald-800 font-bold">2 Active Deals</b></div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-white/50 flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256" alt="Rep">
                    <span class="text-[#427863] font-medium">Michael Lee</span>
                </div>
                <span class="text-[#58967d] font-bold">View Profile →</span>
            </div>
        </div>

        <!-- Company Card 3 -->
        <div class="glass-card glass-card-hover p-5 flex flex-col justify-between cursor-pointer" @click="selectedCompany = { name: 'Apex Logistics', industry: 'Supply Chain', employees: '3,100', revenue: '$890,000', manager: 'Sarah Kim', health: '94% High', openDeals: 4 }">
            <div>
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-700 to-slate-900 flex items-center justify-center text-white font-extrabold text-lg shadow-md border border-white/50">
                        AP
                    </div>
                    <span class="px-2.5 py-1 rounded-full badge-won font-extrabold text-[10px]">94% Health</span>
                </div>
                <h3 class="text-base font-extrabold text-[#1b382b] mt-3">Apex Global Logistics</h3>
                <p class="text-xs text-[#427863] font-semibold">Supply Chain &bull; Enterprise</p>
                
                <div class="mt-4 pt-3 border-t border-white/50 space-y-1.5 text-xs">
                    <div class="flex justify-between"><span class="text-[#427863]">Employees:</span> <b class="text-[#1b382b]">3,100</b></div>
                    <div class="flex justify-between"><span class="text-[#427863]">Revenue Potential:</span> <b class="text-[#58967d] font-extrabold">$890,000</b></div>
                    <div class="flex justify-between"><span class="text-[#427863]">Open Opportunities:</span> <b class="text-emerald-800 font-bold">4 Active Deals</b></div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-white/50 flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=256" alt="Rep">
                    <span class="text-[#427863] font-medium">Sarah Kim</span>
                </div>
                <span class="text-[#58967d] font-bold">View Profile →</span>
            </div>
        </div>

    </div>

    <!-- COMPANY DETAILS DRAWER -->
    <div x-show="selectedCompany !== null" class="fixed inset-y-0 right-0 w-full max-w-md glass-panel p-6 shadow-2xl z-50 animate-fade-in flex flex-col justify-between border-l border-white/80" style="display: none;">
        <div>
            <div class="flex items-center justify-between pb-4 border-b border-white/50">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#58967d]">Company Profile</span>
                    <h2 class="text-lg font-extrabold text-[#1b382b]" x-text="selectedCompany ? selectedCompany.name : ''"></h2>
                </div>
                <button @click="selectedCompany = null" class="text-[#427863] hover:text-[#1b382b] p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="mt-4 space-y-4 text-xs">
                <div class="p-3 rounded-2xl bg-white/70 border border-white/90 space-y-2">
                    <div class="flex justify-between"><span class="text-[#427863]">Industry:</span> <b class="text-[#1b382b]" x-text="selectedCompany ? selectedCompany.industry : ''"></b></div>
                    <div class="flex justify-between"><span class="text-[#427863]">Employees:</span> <b class="text-[#1b382b]" x-text="selectedCompany ? selectedCompany.employees : ''"></b></div>
                    <div class="flex justify-between"><span class="text-[#427863]">Potential Revenue:</span> <b class="text-[#58967d] font-extrabold" x-text="selectedCompany ? selectedCompany.revenue : ''"></b></div>
                    <div class="flex justify-between"><span class="text-[#427863]">Account Manager:</span> <b class="text-[#1b382b]" x-text="selectedCompany ? selectedCompany.manager : ''"></b></div>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-white/50 flex gap-2">
            <button class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white font-bold text-xs shadow-md">Create Deal</button>
            <button @click="selectedCompany = null" class="px-4 py-2.5 rounded-xl glass-pill font-bold text-xs text-[#427863]">Close</button>
        </div>
    </div>

</div>
@endsection

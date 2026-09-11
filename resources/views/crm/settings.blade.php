@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="space-y-4 animate-fade-in" x-data="{ tab: 'general' }">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 glass-card kpi-accent-emerald p-5">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                <svg class="w-6 h-6 text-[#58967d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings & System Configuration
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Customize workspace preferences, pipeline stages, security, and integrations. Powered by BrosTech.</p>
        </div>
    </div>

    <!-- SETTINGS TABS & CONTENT LAYOUT -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        <!-- Left Settings Sidebar Tabs -->
        <div class="md:col-span-3 glass-card p-3 space-y-1 text-xs font-bold">
            <button @click="tab = 'general'" :class="tab === 'general' ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/50'" class="w-full text-left px-3.5 py-2.5 rounded-xl transition-all flex items-center gap-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>General Settings</span>
            </button>
            <button @click="tab = 'workspace'" :class="tab === 'workspace' ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/50'" class="w-full text-left px-3.5 py-2.5 rounded-xl transition-all flex items-center gap-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11"/></svg>
                <span>Workspace</span>
            </button>
            <button @click="tab = 'pipeline'" :class="tab === 'pipeline' ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/50'" class="w-full text-left px-3.5 py-2.5 rounded-xl transition-all flex items-center gap-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Pipeline Stages</span>
            </button>
            <button @click="tab = 'integrations'" :class="tab === 'integrations' ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/50'" class="w-full text-left px-3.5 py-2.5 rounded-xl transition-all flex items-center gap-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Integrations</span>
            </button>
            <button @click="tab = 'billing'" :class="tab === 'billing' ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/50'" class="w-full text-left px-3.5 py-2.5 rounded-xl transition-all flex items-center gap-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>Billing & Plan</span>
            </button>
        </div>

        <!-- Right Settings Panel Body -->
        <div class="md:col-span-9 glass-card p-6">
            
            <!-- General Tab -->
            <div x-show="tab === 'general'" class="space-y-4">
                <h3 class="font-extrabold text-base text-[#1b382b] border-b border-white/50 pb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#58967d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    General System Preferences
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold text-[#2c4d41] mb-1">CRM Platform Name</label>
                        <input type="text" value="Nexora CRM" class="w-full px-3.5 py-2 rounded-xl glass-input font-semibold text-[#1b382b]">
                    </div>
                    <div>
                        <label class="block font-bold text-[#2c4d41] mb-1">Timezone</label>
                        <select class="w-full px-3.5 py-2 rounded-xl glass-input font-semibold text-[#1b382b]">
                            <option>(GMT-08:00) Pacific Time (US & Canada)</option>
                            <option>(GMT+00:00) UTC / London</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-white/50 flex justify-end">
                    <button class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md hover:brightness-110 active:scale-95 transition-all">
                        Save Changes
                    </button>
                </div>
            </div>

            <!-- Workspace Tab -->
            <div x-show="tab === 'workspace'" class="space-y-4" style="display: none;">
                <h3 class="font-extrabold text-base text-[#1b382b] border-b border-white/50 pb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#58967d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11"/></svg>
                    Workspace Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold text-[#2c4d41] mb-1">Organization Name</label>
                        <input type="text" value="Global Enterprise Inc." class="w-full px-3.5 py-2 rounded-xl glass-input font-semibold text-[#1b382b]">
                    </div>
                    <div>
                        <label class="block font-bold text-[#2c4d41] mb-1">Primary Currency</label>
                        <select class="w-full px-3.5 py-2 rounded-xl glass-input font-semibold text-[#1b382b]">
                            <option>USD ($)</option>
                            <option>EUR (€)</option>
                            <option>GBP (£)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Pipeline Tab -->
            <div x-show="tab === 'pipeline'" class="space-y-4" style="display: none;">
                <h3 class="font-extrabold text-base text-[#1b382b] border-b border-white/50 pb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#58967d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Pipeline Stages Configuration
                </h3>
                <div class="space-y-2 text-xs font-bold text-[#1b382b]">
                    <div class="p-3 rounded-xl glass-row flex items-center justify-between">
                        <span>1. New Inbound Lead</span>
                        <span class="badge-new text-[10px] px-2 py-0.5 rounded-full">Default</span>
                    </div>
                    <div class="p-3 rounded-xl glass-row flex items-center justify-between">
                        <span>2. Lead Qualification</span>
                        <span class="badge-qualified text-[10px] px-2 py-0.5 rounded-full">Active</span>
                    </div>
                    <div class="p-3 rounded-xl glass-row flex items-center justify-between">
                        <span>3. Proposal & Quote</span>
                        <span class="badge-proposal text-[10px] px-2 py-0.5 rounded-full">Active</span>
                    </div>
                    <div class="p-3 rounded-xl glass-row flex items-center justify-between">
                        <span>4. Negotiation</span>
                        <span class="badge-negotiation text-[10px] px-2 py-0.5 rounded-full">Active</span>
                    </div>
                    <div class="p-3 rounded-xl glass-row flex items-center justify-between">
                        <span>5. Closed Won</span>
                        <span class="badge-won text-[10px] px-2 py-0.5 rounded-full">Final Stage</span>
                    </div>
                </div>
            </div>

            <!-- Integrations Tab -->
            <div x-show="tab === 'integrations'" class="space-y-4" style="display: none;">
                <h3 class="font-extrabold text-base text-[#1b382b] border-b border-white/50 pb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#58967d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Connected Apps & Services
                </h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 rounded-2xl glass-row">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#58967d]/15 text-[#366050] flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <div>
                                <div class="font-bold text-xs text-[#1b382b]">Slack Integration</div>
                                <div class="text-[10px] text-[#427863]">Instant deal alerts & lead notifications</div>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full badge-won font-bold text-[10px]">Connected</span>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-2xl glass-row">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#58967d]/15 text-[#366050] flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="font-bold text-xs text-[#1b382b]">Stripe Payments</div>
                                <div class="text-[10px] text-[#427863]">Automated customer invoice syncing</div>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full badge-won font-bold text-[10px]">Connected</span>
                    </div>
                </div>
            </div>

            <!-- Billing Tab -->
            <div x-show="tab === 'billing'" class="space-y-4" style="display: none;">
                <h3 class="font-extrabold text-base text-[#1b382b] border-b border-white/50 pb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#58967d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Billing & Subscription Plan
                </h3>
                <div class="glass-panel p-4 rounded-2xl flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-[#1b382b]">Enterprise Unlimited Plan</div>
                        <div class="text-[10px] text-[#427863]">Renews on Dec 31, 2026 &bull; $299/month</div>
                    </div>
                    <span class="px-3 py-1 rounded-full badge-won font-bold text-[10px]">Active Plan</span>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

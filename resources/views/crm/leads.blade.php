@extends('layouts.app')

@section('title', 'Leads Management')

@section('content')
<div class="space-y-6" x-data="{ viewMode: 'table', selectedLead: null, activeTab: 'all' }">

    <!-- PAGE TITLE & CONTROL HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 glass-card p-5">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Leads Management
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#58967d]/15 text-[#366050] font-bold border border-[#58967d]/20">24 Active</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Track, qualify, and convert potential clients through your sales pipeline.</p>
        </div>

        <div class="flex items-center gap-2">
            <!-- View Mode Switcher -->
            <div class="flex items-center p-1 rounded-xl glass-pill">
                <button @click="viewMode = 'table'" :class="viewMode === 'table' ? 'glass-nav-active' : 'text-[#2c4d41]'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    <span>Table</span>
                </button>
                <button @click="viewMode = 'kanban'" :class="viewMode === 'kanban' ? 'glass-nav-active' : 'text-[#2c4d41]'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 01-2-2h-2a2 2 0 01-2 2"/></svg>
                    <span>Kanban</span>
                </button>
            </div>

            <button class="px-3 py-2 rounded-xl glass-pill text-xs font-bold text-[#2c4d41] hover:bg-white/80 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Export CSV</span>
            </button>

            <button @click="quickModalOpen = true" class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md shadow-[#366050]/20 hover:brightness-110 active:scale-95 transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Lead</span>
            </button>
        </div>
    </div>

    <!-- FILTER & STATUS TABS BAR -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 glass-card p-3">
        <!-- Status Tabs -->
        <div class="flex items-center gap-1 overflow-x-auto pb-1 md:pb-0">
            <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-[#58967d] text-white' : 'text-[#2c4d41] hover:bg-white/50'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all">All Leads (24)</button>
            <button @click="activeTab = 'new'" :class="activeTab === 'new' ? 'bg-[#58967d] text-white' : 'text-[#2c4d41] hover:bg-white/50'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all">New (8)</button>
            <button @click="activeTab = 'qualified'" :class="activeTab === 'qualified' ? 'bg-[#58967d] text-white' : 'text-[#2c4d41] hover:bg-white/50'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all">Qualified (6)</button>
            <button @click="activeTab = 'proposal'" :class="activeTab === 'proposal' ? 'bg-[#58967d] text-white' : 'text-[#2c4d41] hover:bg-white/50'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all">Proposal (5)</button>
            <button @click="activeTab = 'negotiation'" :class="activeTab === 'negotiation' ? 'bg-[#58967d] text-white' : 'text-[#2c4d41] hover:bg-white/50'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all">Negotiation (3)</button>
            <button @click="activeTab = 'won'" :class="activeTab === 'won' ? 'bg-[#58967d] text-white' : 'text-[#2c4d41] hover:bg-white/50'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all">Won (2)</button>
        </div>

        <!-- Search Input inside bar -->
        <div class="w-full md:w-64">
            <input type="text" placeholder="Filter leads by name or company..." class="w-full px-3.5 py-1.5 text-xs font-medium rounded-xl glass-input text-[#1b382b]">
        </div>
    </div>

    <!-- MAIN VIEW CONTENT: TABLE OR KANBAN -->
    <div class="relative">

        <!-- 1. DATA TABLE VIEW -->
        <div x-show="viewMode === 'table'" class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-white/60 bg-white/40 text-[#427863] font-bold uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-4">Lead Name</th>
                            <th class="py-3 px-4">Company</th>
                            <th class="py-3 px-4">Source</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Assigned To</th>
                            <th class="py-3 px-4">Deal Value</th>
                            <th class="py-3 px-4">Last Contact</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/40 text-[#1b382b]">
                        
                        <!-- Row 1 -->
                        <tr class="hover:bg-white/70 transition-colors cursor-pointer" @click="selectedLead = { name: 'Eleanor Vance', company: 'Apex Global Logistics', email: 'eleanor@apexglobal.com', phone: '+1 (555) 234-5678', source: 'Website Demo', status: 'Qualified', owner: 'Olivia Carter', value: '$65,000', priority: 'High' }">
                            <td class="py-3.5 px-4 font-bold flex items-center gap-3">
                                <img class="w-8 h-8 rounded-full ring-2 ring-[#58967d]/30 object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                                <div>
                                    <div class="font-bold text-[#1b382b]">Eleanor Vance</div>
                                    <div class="text-[10px] text-[#427863]">eleanor@apexglobal.com</div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-medium">Apex Global Logistics</td>
                            <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md glass-pill text-[10px] font-semibold text-[#366050]">Website Demo</span></td>
                            <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded-full badge-qualified font-extrabold text-[10px]">Qualified</span></td>
                            <td class="py-3.5 px-4 font-medium flex items-center gap-2">
                                <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=256" alt="Olivia">
                                <span>Olivia Carter</span>
                            </td>
                            <td class="py-3.5 px-4 font-extrabold text-[#1b382b]">$65,000</td>
                            <td class="py-3.5 px-4 text-[#427863]">Today, 9:30 AM</td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="p-1.5 rounded-lg hover:bg-white/80 text-[#58967d] font-bold">View →</button>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-white/70 transition-colors cursor-pointer" @click="selectedLead = { name: 'Marcus Brody', company: 'Horizon Robotics', email: 'marcus@horizonrobotics.io', phone: '+1 (555) 987-6543', source: 'LinkedIn Outbound', status: 'Proposal', owner: 'Michael Lee', value: '$120,000', priority: 'Urgent' }">
                            <td class="py-3.5 px-4 font-bold flex items-center gap-3">
                                <img class="w-8 h-8 rounded-full ring-2 ring-[#58967d]/30 object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                                <div>
                                    <div class="font-bold text-[#1b382b]">Marcus Brody</div>
                                    <div class="text-[10px] text-[#427863]">marcus@horizonrobotics.io</div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-medium">Horizon Robotics</td>
                            <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md glass-pill text-[10px] font-semibold text-[#366050]">LinkedIn Outbound</span></td>
                            <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded-full badge-proposal font-extrabold text-[10px]">Proposal</span></td>
                            <td class="py-3.5 px-4 font-medium flex items-center gap-2">
                                <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256" alt="Michael">
                                <span>Michael Lee</span>
                            </td>
                            <td class="py-3.5 px-4 font-extrabold text-[#1b382b]">$120,000</td>
                            <td class="py-3.5 px-4 text-[#427863]">Yesterday</td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="p-1.5 rounded-lg hover:bg-white/80 text-[#58967d] font-bold">View →</button>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="hover:bg-white/70 transition-colors cursor-pointer" @click="selectedLead = { name: 'Sophia Chen', company: 'EcoCloud Systems', email: 'sophia@ecocloud.net', phone: '+1 (555) 456-7890', source: 'Referral', status: 'New', owner: 'Sarah Kim', value: '$42,500', priority: 'Medium' }">
                            <td class="py-3.5 px-4 font-bold flex items-center gap-3">
                                <img class="w-8 h-8 rounded-full ring-2 ring-[#58967d]/30 object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=256" alt="Avatar">
                                <div>
                                    <div class="font-bold text-[#1b382b]">Sophia Chen</div>
                                    <div class="text-[10px] text-[#427863]">sophia@ecocloud.net</div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-medium">EcoCloud Systems</td>
                            <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md glass-pill text-[10px] font-semibold text-[#366050]">Partner Referral</span></td>
                            <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded-full badge-new font-extrabold text-[10px]">New Lead</span></td>
                            <td class="py-3.5 px-4 font-medium flex items-center gap-2">
                                <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=256" alt="Sarah">
                                <span>Sarah Kim</span>
                            </td>
                            <td class="py-3.5 px-4 font-extrabold text-[#1b382b]">$42,500</td>
                            <td class="py-3.5 px-4 text-[#427863]">3 hours ago</td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="p-1.5 rounded-lg hover:bg-white/80 text-[#58967d] font-bold">View →</button>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="hover:bg-white/70 transition-colors cursor-pointer" @click="selectedLead = { name: 'David Miller', company: 'Vanguard Capital', email: 'd.miller@vanguardcap.com', phone: '+1 (555) 789-0123', source: 'Cold Email', status: 'Negotiation', owner: 'Olivia Carter', value: '$180,000', priority: 'High' }">
                            <td class="py-3.5 px-4 font-bold flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#2c4d41] text-white flex items-center justify-center font-bold text-xs">DM</div>
                                <div>
                                    <div class="font-bold text-[#1b382b]">David Miller</div>
                                    <div class="text-[10px] text-[#427863]">d.miller@vanguardcap.com</div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-medium">Vanguard Capital</td>
                            <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md glass-pill text-[10px] font-semibold text-[#366050]">Cold Email Sequence</span></td>
                            <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded-full badge-negotiation font-extrabold text-[10px]">Negotiation</span></td>
                            <td class="py-3.5 px-4 font-medium flex items-center gap-2">
                                <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=256" alt="Olivia">
                                <span>Olivia Carter</span>
                            </td>
                            <td class="py-3.5 px-4 font-extrabold text-[#1b382b]">$180,000</td>
                            <td class="py-3.5 px-4 text-[#427863]">Sep 8, 2:15 PM</td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="p-1.5 rounded-lg hover:bg-white/80 text-[#58967d] font-bold">View →</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. KANBAN BOARD VIEW -->
        <div x-show="viewMode === 'kanban'" class="grid grid-cols-1 md:grid-cols-4 gap-4 overflow-x-auto pb-4" style="display: none;">
            
            <!-- Column 1: New -->
            <div class="glass-card p-3 flex flex-col gap-3 min-w-[260px]">
                <div class="flex items-center justify-between pb-2 border-b border-white/50">
                    <span class="font-extrabold text-xs text-[#1b382b]">New Leads</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-new">8 Cards</span>
                </div>
                <div class="space-y-3">
                    <div class="glass-card glass-card-hover p-3 cursor-pointer" @click="selectedLead = { name: 'Sophia Chen', company: 'EcoCloud Systems', value: '$42,500' }">
                        <div class="text-xs font-bold text-[#1b382b]">Sophia Chen</div>
                        <div class="text-[11px] text-[#427863]">EcoCloud Systems</div>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="font-extrabold text-xs text-[#1b382b]">$42,500</span>
                            <span class="text-[9px] px-2 py-0.5 rounded-md glass-pill text-[#366050]">Partner</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 2: Qualified -->
            <div class="glass-card p-3 flex flex-col gap-3 min-w-[260px]">
                <div class="flex items-center justify-between pb-2 border-b border-white/50">
                    <span class="font-extrabold text-xs text-[#1b382b]">Qualified</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-qualified">6 Cards</span>
                </div>
                <div class="space-y-3">
                    <div class="glass-card glass-card-hover p-3 cursor-pointer" @click="selectedLead = { name: 'Eleanor Vance', company: 'Apex Global Logistics', value: '$65,000' }">
                        <div class="text-xs font-bold text-[#1b382b]">Eleanor Vance</div>
                        <div class="text-[11px] text-[#427863]">Apex Global Logistics</div>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="font-extrabold text-xs text-[#1b382b]">$65,000</span>
                            <span class="text-[9px] px-2 py-0.5 rounded-md glass-pill text-[#366050]">Demo Done</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 3: Proposal -->
            <div class="glass-card p-3 flex flex-col gap-3 min-w-[260px]">
                <div class="flex items-center justify-between pb-2 border-b border-white/50">
                    <span class="font-extrabold text-xs text-[#1b382b]">Proposal Sent</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-proposal">5 Cards</span>
                </div>
                <div class="space-y-3">
                    <div class="glass-card glass-card-hover p-3 cursor-pointer" @click="selectedLead = { name: 'Marcus Brody', company: 'Horizon Robotics', value: '$120,000' }">
                        <div class="text-xs font-bold text-[#1b382b]">Marcus Brody</div>
                        <div class="text-[11px] text-[#427863]">Horizon Robotics</div>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="font-extrabold text-xs text-[#1b382b]">$120,000</span>
                            <span class="text-[9px] px-2 py-0.5 rounded-md glass-pill text-[#366050]">Under Review</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 4: Negotiation -->
            <div class="glass-card p-3 flex flex-col gap-3 min-w-[260px]">
                <div class="flex items-center justify-between pb-2 border-b border-white/50">
                    <span class="font-extrabold text-xs text-[#1b382b]">Negotiation</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-negotiation">3 Cards</span>
                </div>
                <div class="space-y-3">
                    <div class="glass-card glass-card-hover p-3 cursor-pointer" @click="selectedLead = { name: 'David Miller', company: 'Vanguard Capital', value: '$180,000' }">
                        <div class="text-xs font-bold text-[#1b382b]">David Miller</div>
                        <div class="text-[11px] text-[#427863]">Vanguard Capital</div>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="font-extrabold text-xs text-[#1b382b]">$180,000</span>
                            <span class="text-[9px] px-2 py-0.5 rounded-md glass-pill text-[#366050]">Legal Terms</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT SLIDE-OVER LEAD DETAIL PANEL -->
        <div x-show="selectedLead !== null" class="fixed inset-y-0 right-0 w-full max-w-md glass-panel p-6 shadow-2xl z-50 animate-fade-in flex flex-col justify-between border-l border-white/80" style="display: none;">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-white/50">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#58967d]">Lead Inspection Drawer</span>
                        <h2 class="text-lg font-extrabold text-[#1b382b]" x-text="selectedLead ? selectedLead.name : ''"></h2>
                    </div>
                    <button @click="selectedLead = null" class="text-[#427863] hover:text-[#1b382b] p-1 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="mt-4 space-y-4 text-xs">
                    <div class="p-3 rounded-2xl bg-white/70 border border-white/90 space-y-2">
                        <div class="flex justify-between"><span class="text-[#427863] font-medium">Company:</span> <b class="text-[#1b382b]" x-text="selectedLead ? selectedLead.company : ''"></b></div>
                        <div class="flex justify-between"><span class="text-[#427863] font-medium">Deal Value:</span> <b class="text-[#58967d] font-extrabold" x-text="selectedLead ? selectedLead.value : ''"></b></div>
                        <div class="flex justify-between"><span class="text-[#427863] font-medium">Status:</span> <b class="text-[#2c4d41]" x-text="selectedLead ? selectedLead.status : ''"></b></div>
                        <div class="flex justify-between"><span class="text-[#427863] font-medium">Lead Owner:</span> <b class="text-[#1b382b]" x-text="selectedLead ? selectedLead.owner : ''"></b></div>
                    </div>

                    <div>
                        <h4 class="font-bold text-[#1b382b] mb-1">Notes & Interaction Log</h4>
                        <textarea rows="3" class="w-full p-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]" placeholder="Add follow-up notes here..."></textarea>
                    </div>

                    <div>
                        <h4 class="font-bold text-[#1b382b] mb-2">Lead Activity Timeline</h4>
                        <div class="space-y-2 border-l-2 border-[#58967d]/40 pl-3">
                            <div>
                                <div class="font-semibold text-[#1b382b]">Sent custom proposal PDF</div>
                                <div class="text-[10px] text-[#427863]">Today, 11:20 AM</div>
                            </div>
                            <div>
                                <div class="font-semibold text-[#1b382b]">Completed initial discovery call</div>
                                <div class="text-[10px] text-[#427863]">Yesterday, 3:45 PM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-white/50 flex gap-2">
                <button class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white font-bold text-xs shadow-md">Convert to Customer</button>
                <button @click="selectedLead = null" class="px-4 py-2.5 rounded-xl glass-pill font-bold text-xs text-[#427863]">Close</button>
            </div>
        </div>

    </div>

</div>
@endsection

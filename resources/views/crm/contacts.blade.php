@extends('layouts.app')

@section('title', 'Contacts & Customers')

@section('content')
<div class="space-y-4 animate-fade-in" x-data="{ selectedCustomer: null }">

    {{-- PAGE HEADER --}}
    <div class="glass-card kpi-accent-blue p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Contacts & Customers
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 font-bold border border-emerald-500/20">482 Total</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Manage existing client accounts, key stakeholders, and customer relationships.</p>
        </div>
        <button @click="quickModalOpen = true"
                class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md flex items-center gap-2 hover:brightness-110 active:scale-95 transition-all flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Customer
        </button>
    </div>

    {{-- STATS ROW --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        @php
            $contactStats = [
                ['label' => 'Active', 'value' => '376', 'color' => 'kpi-accent-emerald', 'bg' => 'bg-[#58967d]/15 text-[#366050]'],
                ['label' => 'Onboarding', 'value' => '58', 'color' => 'kpi-accent-blue', 'bg' => 'bg-blue-500/15 text-blue-700'],
                ['label' => 'At Risk', 'value' => '29', 'color' => 'kpi-accent-amber', 'bg' => 'bg-amber-500/15 text-amber-700'],
                ['label' => 'Churned', 'value' => '19', 'color' => 'kpi-accent-rose', 'bg' => 'bg-rose-500/15 text-rose-700'],
            ];
        @endphp
        @foreach($contactStats as $stat)
        <div class="glass-card {{ $stat['color'] }} p-4">
            <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">{{ $stat['label'] }}</div>
            <div class="text-2xl font-extrabold text-[#1b382b] mt-1">{{ $stat['value'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- FILTER BAR --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 glass-card p-3">
        <input type="text" placeholder="Search by name or email..." class="px-3.5 py-2 text-xs font-medium rounded-xl glass-input text-[#1b382b]">
        <select class="px-3.5 py-2 text-xs font-semibold rounded-xl glass-input text-[#1b382b]">
            <option>All Companies</option>
            <option>Acme Corp</option>
            <option>GreenTech Solutions</option>
            <option>Apex Global</option>
        </select>
        <select class="px-3.5 py-2 text-xs font-semibold rounded-xl glass-input text-[#1b382b]">
            <option>Segment: All</option>
            <option>Enterprise</option>
            <option>Mid-Market</option>
            <option>SMB</option>
        </select>
        <select class="px-3.5 py-2 text-xs font-semibold rounded-xl glass-input text-[#1b382b]">
            <option>Assigned Rep: All</option>
            <option>Olivia Carter</option>
            <option>Michael Lee</option>
            <option>Sarah Kim</option>
        </select>
    </div>

    {{-- CONTACTS TABLE --}}
    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs glass-table">
                <thead>
                    <tr class="text-[#427863] font-bold uppercase text-[10px] tracking-wider">
                        <th class="py-3 px-4">Customer Name</th>
                        <th class="py-3 px-4">Company</th>
                        <th class="py-3 px-4">Segment</th>
                        <th class="py-3 px-4">Location</th>
                        <th class="py-3 px-4 text-right">Lifetime Value</th>
                        <th class="py-3 px-4 text-right">Last Interaction</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Details</th>
                    </tr>
                </thead>
                <tbody class="text-[#1b382b]">
                    @php
                        $contacts = [
                            ['name' => 'Sarah Jenkins', 'role' => 'VP of Operations', 'company' => 'Acme Corp', 'email' => 'sarah.j@acmecorp.com', 'phone' => '+1 (555) 345-6789', 'location' => 'San Francisco, CA', 'segment' => 'Enterprise', 'segment_class' => 'bg-[#58967d]/15 text-[#366050]', 'ltv' => '$145,000', 'last' => '2 hours ago', 'status' => 'Active', 'status_class' => 'badge-won', 'nextMeeting' => 'Tomorrow, 10:00 AM', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                            ['name' => 'David Kim', 'role' => 'CTO', 'company' => 'GreenTech Solutions', 'email' => 'dkim@greentech.org', 'phone' => '+1 (555) 876-5432', 'location' => 'Seattle, WA', 'segment' => 'Mid-Market', 'segment_class' => 'bg-teal-500/15 text-teal-800', 'ltv' => '$88,000', 'last' => 'Yesterday', 'status' => 'Onboarding', 'status_class' => 'badge-proposal', 'nextMeeting' => 'Sep 12, 2:30 PM', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                            ['name' => 'Eleanor Vance', 'role' => 'COO', 'company' => 'Apex Global Logistics', 'email' => 'eleanor@apexglobal.com', 'phone' => '+1 (555) 234-5678', 'location' => 'New York, NY', 'segment' => 'Enterprise', 'segment_class' => 'bg-[#58967d]/15 text-[#366050]', 'ltv' => '$210,000', 'last' => 'Sep 8', 'status' => 'Active', 'status_class' => 'badge-won', 'nextMeeting' => 'Sep 14, 9:00 AM', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=64'],
                            ['name' => 'Marcus Brody', 'role' => 'CEO', 'company' => 'Horizon Robotics', 'email' => 'marcus@horizonrobotics.io', 'phone' => '+1 (555) 987-6543', 'location' => 'Austin, TX', 'segment' => 'Mid-Market', 'segment_class' => 'bg-teal-500/15 text-teal-800', 'ltv' => '$98,000', 'last' => 'Sep 5', 'status' => 'At Risk', 'status_class' => 'badge-negotiation', 'nextMeeting' => 'TBD', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                            ['name' => 'Sophia Chen', 'role' => 'VP Product', 'company' => 'EcoCloud Systems', 'email' => 'sophia@ecocloud.net', 'phone' => '+1 (555) 456-7890', 'location' => 'Chicago, IL', 'segment' => 'SMB', 'segment_class' => 'bg-blue-500/15 text-blue-700', 'ltv' => '$42,500', 'last' => '3 hours ago', 'status' => 'Active', 'status_class' => 'badge-won', 'nextMeeting' => 'Sep 11, 3:00 PM', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                        ];
                    @endphp
                    @foreach($contacts as $contact)
                    <tr class="cursor-pointer"
                        @click="selectedCustomer = {{ json_encode($contact) }}">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-white/60 flex-shrink-0"
                                     src="{{ $contact['avatar'] }}" alt="{{ $contact['name'] }}">
                                <div>
                                    <div class="font-bold text-[#1b382b]">{{ $contact['name'] }}</div>
                                    <div class="text-[10px] text-[#427863]">{{ $contact['email'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 font-semibold">{{ $contact['company'] }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded-full {{ $contact['segment_class'] }} font-extrabold text-[10px]">{{ $contact['segment'] }}</span>
                        </td>
                        <td class="py-3 px-4 text-[#427863]">{{ $contact['location'] }}</td>
                        <td class="py-3 px-4 text-right font-extrabold text-[#1b382b]">{{ $contact['ltv'] }}</td>
                        <td class="py-3 px-4 text-right text-[#427863]">{{ $contact['last'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2 py-0.5 rounded-full {{ $contact['status_class'] }} font-extrabold text-[10px]">{{ $contact['status'] }}</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button class="text-[11px] font-bold text-[#58967d] hover:underline">Inspect →</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- SLIDE-OVER DETAIL PANEL --}}
    <div x-show="selectedCustomer !== null"
         class="fixed inset-y-0 right-0 w-full max-w-md glass-panel p-6 shadow-2xl z-50 animate-fade-in flex flex-col justify-between border-l border-white/60"
         style="display:none;">
        <div>
            <div class="flex items-center justify-between pb-4 border-b border-white/40">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#58967d] to-[#2c4d41] flex items-center justify-center text-white font-extrabold text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-[#1b382b]" x-text="selectedCustomer?.name"></h2>
                        <p class="text-[11px] text-[#427863]" x-text="(selectedCustomer?.role ?? '') + ' · ' + (selectedCustomer?.company ?? '')"></p>
                    </div>
                </div>
                <button @click="selectedCustomer = null" class="text-[#427863] hover:text-[#1b382b] p-1.5 rounded-xl hover:bg-white/40">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="mt-4 space-y-3 text-xs">
                <div class="p-3.5 rounded-2xl glass-row space-y-2.5">
                    <div class="flex justify-between"><span class="text-[#427863] font-medium">Email:</span> <span class="font-bold text-[#1b382b]" x-text="selectedCustomer?.email"></span></div>
                    <div class="flex justify-between"><span class="text-[#427863] font-medium">Phone:</span> <span class="font-bold text-[#1b382b]" x-text="selectedCustomer?.phone"></span></div>
                    <div class="flex justify-between"><span class="text-[#427863] font-medium">Location:</span> <span class="font-bold text-[#1b382b]" x-text="selectedCustomer?.location"></span></div>
                    <div class="flex justify-between"><span class="text-[#427863] font-medium">Lifetime Value:</span> <span class="font-extrabold text-[#58967d]" x-text="selectedCustomer?.ltv"></span></div>
                    <div class="flex justify-between"><span class="text-[#427863] font-medium">Next Meeting:</span> <span class="font-bold text-amber-800" x-text="selectedCustomer?.nextMeeting"></span></div>
                    <div class="flex justify-between"><span class="text-[#427863] font-medium">Status:</span> <span class="font-bold text-[#1b382b]" x-text="selectedCustomer?.status"></span></div>
                </div>
                <div>
                    <h4 class="font-bold text-[#1b382b] mb-2 text-sm">Interaction Notes</h4>
                    <textarea rows="3" class="w-full p-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]" placeholder="Add notes about this customer..."></textarea>
                </div>
            </div>
        </div>
        <div class="pt-4 border-t border-white/40 flex gap-2">
            <button class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white font-bold text-xs shadow-md hover:brightness-110 transition-all">Schedule Meeting</button>
            <button @click="selectedCustomer = null" class="px-4 py-2.5 rounded-xl glass-pill font-bold text-xs text-[#427863]">Close</button>
        </div>
    </div>

</div>
@endsection

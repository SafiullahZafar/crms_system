@extends('layouts.app')

@section('title', 'Tasks & Follow-ups')

@section('content')
<div class="space-y-4 animate-fade-in" x-data="{ currentTab: 'today' }">

    {{-- PAGE HEADER --}}
    <div class="glass-card kpi-accent-emerald p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Tasks & Follow-ups
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 font-bold border border-emerald-500/20">5 Due Today</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Stay on top of sales calls, proposal deadlines, and client meetings.</p>
        </div>
        <button @click="quickModalOpen = true"
                class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md flex items-center gap-2 hover:brightness-110 active:scale-95 transition-all flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Task
        </button>
    </div>

    {{-- TASK STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        @php
            $taskStats = [
                ['label' => 'Due Today', 'value' => '5', 'c' => 'kpi-accent-emerald'],
                ['label' => 'Upcoming', 'value' => '8', 'c' => 'kpi-accent-emerald'],
                ['label' => 'Overdue', 'value' => '2', 'c' => 'kpi-accent-rose'],
                ['label' => 'Completed', 'value' => '14', 'c' => 'kpi-accent-emerald']
            ];
        @endphp
        @foreach($taskStats as $s)
        <div class="glass-card {{ $s['c'] }} p-4 text-center">
            <div class="text-2xl font-extrabold text-[#1b382b]">{{ $s['value'] }}</div>
            <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider mt-1">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- TABS --}}
    <div class="flex items-center gap-2 glass-card p-2 text-xs font-bold flex-wrap">
        <button @click="currentTab = 'today'" :class="currentTab === 'today' ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/40'" class="px-4 py-2 rounded-xl transition-all">Today (5)</button>
        <button @click="currentTab = 'upcoming'" :class="currentTab === 'upcoming' ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/40'" class="px-4 py-2 rounded-xl transition-all">Upcoming (8)</button>
        <button @click="currentTab = 'overdue'" :class="currentTab === 'overdue' ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/40'" class="px-4 py-2 rounded-xl transition-all">Overdue (2)</button>
        <button @click="currentTab = 'completed'" :class="currentTab === 'completed' ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/40'" class="px-4 py-2 rounded-xl transition-all">Completed (14)</button>
    </div>

    {{-- TASK LIST --}}
    <div class="space-y-2">
        @php
            $tasks = [
                ['title' => 'Follow up with Acme Corp on Enterprise contract renewal', 'company' => 'Acme Corp', 'priority' => 'High', 'priority_class' => 'bg-rose-500/15 text-rose-800 border-rose-500/20', 'due' => 'Today, 10:00 AM', 'due_class' => 'text-rose-600', 'done' => false, 'type' => 'Call', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                ['title' => 'Send customized pricing proposal to GreenTech Solutions', 'company' => 'GreenTech Solutions', 'priority' => 'High', 'priority_class' => 'bg-rose-500/15 text-rose-800 border-rose-500/20', 'due' => 'Today, 2:00 PM', 'due_class' => 'text-rose-600', 'done' => false, 'type' => 'Email', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
                ['title' => 'Prepare technical demo presentation for Horizon Ltd', 'company' => 'Horizon Robotics', 'priority' => 'Medium', 'priority_class' => 'bg-[#58967d]/15 text-[#366050] border-[#58967d]/20', 'due' => 'Tomorrow, 11:00 AM', 'due_class' => 'text-[#427863]', 'done' => false, 'type' => 'Meeting', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=64'],
                ['title' => 'Discovery call with new lead — Jane Smith at BlueSky Finance', 'company' => 'BlueSky Finance', 'priority' => 'Low', 'priority_class' => 'bg-[#58967d]/15 text-[#366050] border-[#58967d]/20', 'due' => 'Sep 12, 9:30 AM', 'due_class' => 'text-[#427863]', 'done' => false, 'type' => 'Call', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=64'],
                ['title' => 'Review and sign off final contract with Vanguard Capital', 'company' => 'Vanguard Capital', 'priority' => 'High', 'priority_class' => 'bg-rose-500/15 text-rose-800 border-rose-500/20', 'due' => 'Today, 4:00 PM', 'due_class' => 'text-rose-600', 'done' => false, 'type' => 'Review', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=64'],
            ];
        @endphp
        @foreach($tasks as $task)
        <div class="glass-card p-4 flex items-center gap-4 hover:bg-white/25 transition-all group cursor-pointer">
            <input type="checkbox" {{ $task['done'] ? 'checked' : '' }}
                   class="w-5 h-5 rounded text-[#58967d] border-[#58967d]/40 focus:ring-[#58967d] flex-shrink-0">
            <div class="flex-1 min-w-0">
                <div class="font-bold text-sm text-[#1b382b] {{ $task['done'] ? 'line-through opacity-50' : '' }}">{{ $task['title'] }}</div>
                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                    <span class="px-2 py-0.5 rounded-full {{ $task['priority_class'] }} font-bold text-[10px] border">{{ $task['priority'] }} Priority</span>
                    <span class="px-2 py-0.5 rounded-full glass-pill font-bold text-[10px] text-[#2c4d41]">{{ $task['type'] }}</span>
                    <span class="text-[11px] text-[#427863] font-medium">{{ $task['company'] }}</span>
                    <span class="{{ $task['due_class'] }} font-bold text-[11px]">• {{ $task['due'] }}</span>
                </div>
            </div>
            <img class="w-9 h-9 rounded-xl ring-2 ring-white/60 flex-shrink-0 object-cover"
                 src="{{ $task['avatar'] }}" alt="Assigned">
        </div>
        @endforeach
    </div>

</div>
@endsection

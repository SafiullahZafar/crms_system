@extends('layouts.app')

@section('title', 'Calendar & Meetings')

@section('content')
<div class="space-y-4 animate-fade-in">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 glass-card kpi-accent-purple p-5">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Calendar & Meetings
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#58967d]/15 text-[#366050] font-bold border border-[#58967d]/20">September 2026</span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Schedule sales demos, discovery calls, and contract review sessions.</p>
        </div>

        <div class="flex items-center gap-2">
            <div class="flex items-center p-1 rounded-xl glass-pill text-xs font-bold">
                <button class="px-3 py-1.5 rounded-lg glass-nav-active">Month</button>
                <button class="px-3 py-1.5 rounded-lg text-[#2c4d41]">Week</button>
                <button class="px-3 py-1.5 rounded-lg text-[#2c4d41]">Day</button>
            </div>

            <button class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md">
                + Schedule Meeting
            </button>
        </div>
    </div>

    <!-- CALENDAR GRID -->
    <div class="glass-card p-5">
        <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-[#427863] mb-3 pb-2 border-b border-white/50">
            <div>MON</div><div>TUE</div><div>WED</div><div>THU</div><div>FRI</div><div>SAT</div><div>SUN</div>
        </div>

        <div class="grid grid-cols-7 gap-2">
            @php
                $calDays = [
                    ['day' => 1, 'events' => [], 'weekend' => false, 'past' => true],
                    ['day' => 2, 'events' => [], 'weekend' => false, 'past' => true],
                    ['day' => 3, 'events' => [['time' => '9:00 AM', 'title' => 'GreenTech Intro Call', 'color' => 'bg-teal-600']], 'weekend' => false, 'past' => true],
                    ['day' => 4, 'events' => [], 'weekend' => false, 'past' => true],
                    ['day' => 5, 'events' => [['time' => '3:00 PM', 'title' => 'Vanguard Negotiation', 'color' => 'bg-amber-600']], 'weekend' => false, 'past' => true],
                    ['day' => 6, 'events' => [], 'weekend' => true, 'past' => true],
                    ['day' => 7, 'events' => [], 'weekend' => true, 'past' => true],
                    ['day' => 8, 'events' => [], 'weekend' => false, 'past' => true],
                    ['day' => 9, 'events' => [['time' => '10:00 AM', 'title' => 'Acme Corp Sync', 'color' => 'bg-[#58967d]']], 'weekend' => false, 'past' => true],
                    ['day' => 10, 'events' => [['time' => '2:00 PM', 'title' => 'Horizon Demo Call', 'color' => 'bg-blue-600']], 'weekend' => false, 'today' => true, 'past' => false],
                    ['day' => 11, 'events' => [['time' => '11:00 AM', 'title' => 'Apex Proposal Review', 'color' => 'bg-purple-600']], 'weekend' => false, 'past' => false],
                    ['day' => 12, 'events' => [], 'weekend' => false, 'past' => false],
                    ['day' => 13, 'events' => [], 'weekend' => true, 'past' => false],
                    ['day' => 14, 'events' => [], 'weekend' => true, 'past' => false],
                    ['day' => 15, 'events' => [['time' => '9:30 AM', 'title' => 'EcoCloud Discovery', 'color' => 'bg-emerald-700']], 'weekend' => false, 'past' => false],
                    ['day' => 16, 'events' => [], 'weekend' => false, 'past' => false],
                    ['day' => 17, 'events' => [['time' => '1:00 PM', 'title' => 'Contract Signing: Acme', 'color' => 'bg-[#366050]']], 'weekend' => false, 'past' => false],
                    ['day' => 18, 'events' => [], 'weekend' => false, 'past' => false],
                    ['day' => 19, 'events' => [['time' => '4:00 PM', 'title' => 'Q3 Pipeline Review', 'color' => 'bg-rose-600']], 'weekend' => false, 'past' => false],
                    ['day' => 20, 'events' => [], 'weekend' => true, 'past' => false],
                    ['day' => 21, 'events' => [], 'weekend' => true, 'past' => false],
                ];
            @endphp
            @foreach($calDays as $d)
            <div class="p-2 min-h-[90px] rounded-xl text-xs transition-all cursor-pointer hover:bg-white/30
                        {{ $d['past'] ?? false ? 'opacity-50' : '' }}
                        {{ isset($d['today']) ? 'bg-[#58967d]/12 border border-[#58967d]/30' : 'glass-row' }}
                        {{ ($d['weekend'] ?? false) ? 'opacity-40' : '' }}">
                <span class="font-extrabold {{ isset($d['today']) ? 'text-[#58967d] text-sm' : 'text-[#1b382b]' }}">{{ $d['day'] }}</span>
                @if(isset($d['today'])) <span class="text-[9px] text-[#58967d] font-bold block">Today</span> @endif
                @foreach($d['events'] as $ev)
                <div class="mt-1 px-1.5 py-1 rounded-lg {{ $ev['color'] }} text-white text-[9px] font-bold leading-tight truncate">{{ $ev['time'] }} {{ $ev['title'] }}</div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

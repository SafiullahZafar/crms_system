<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Nexora CRM') — Powered by BrosTech</title>
    <meta name="description" content="Nexora CRM — Enterprise sales platform powered by BrosTech. Manage leads, deals, contacts and pipeline intelligence.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="h-full font-sans antialiased text-[#1b382b] bg-[#e4eee8] selection:bg-[#58967d] selection:text-white overflow-x-hidden"
    x-data="{
        quickModalOpen: false,
        searchModalOpen: false,
        mobileSidebarOpen: false,
        sidebarExpanded: true
    }"
    @keydown.window.escape="quickModalOpen = false; searchModalOpen = false"
    @keydown.window.ctrl.k.prevent="searchModalOpen = true"
>

    @php
        $currentRoute = Route::currentRouteName() ?? 'dashboard';
        $isDemo = request()->routeIs('demo.*');
        $demoPage = $isDemo ? str_replace('demo.', '', $currentRoute) : null;
        $bgImage = match($currentRoute) {
            'login'     => asset('images/bg-login.png'),
            'dashboard' => asset('images/bg-dashboard.png'),
            default     => asset('images/bg-general.png'),
        };
    @endphp

    {{-- ══════════════════════════════════════
         AMBIENT BACKGROUND LAYER
    ══════════════════════════════════════ --}}
    <div class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat pointer-events-none scale-[1.03] transition-all duration-700"
         style="background-image: url('{{ $bgImage }}'); filter: brightness(1.04) contrast(1.02) saturate(1.05);">
    </div>

    {{-- Gradient overlay --}}
    <div class="fixed inset-0 z-0 bg-gradient-to-br from-white/20 via-emerald-50/15 to-teal-900/10 pointer-events-none"></div>

    {{-- Noise texture for depth --}}
    <div class="fixed inset-0 z-0 pointer-events-none opacity-[0.025]"
         style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22/%3E%3C/svg%3E');"></div>

    {{-- ══════════════════════════════════════
         APP SHELL
    ══════════════════════════════════════ --}}
    <div class="relative z-10 flex h-screen w-screen overflow-hidden">

        @if($currentRoute !== 'login')

        {{-- ══════════════════════════════════════
             FLOATING SIDEBAR
        ══════════════════════════════════════ --}}
        {{-- Mobile overlay --}}
        <div x-show="mobileSidebarOpen"
             @click="mobileSidebarOpen = false"
             class="fixed inset-0 z-20 bg-black/30 backdrop-blur-sm md:hidden"
             style="display:none;"></div>

        <aside
            class="fixed left-3 top-3 bottom-3 z-30 glass-sidebar rounded-2xl flex flex-col justify-between transition-all duration-300 ease-in-out overflow-hidden"
            :class="{
                'w-[220px]': sidebarExpanded,
                'w-[60px]': !sidebarExpanded,
                'translate-x-0': mobileSidebarOpen || true,
                '-translate-x-[calc(100%+16px)] md:translate-x-0': !mobileSidebarOpen && false
            }"
            style="box-shadow: 0 8px 40px rgba(27,56,43,0.14), 0 2px 0 rgba(255,255,255,0.6) inset;"
        >

            {{-- ── LOGO / COLLAPSE TOGGLE ── --}}
            <div class="flex items-center border-b border-white/30 flex-shrink-0 relative group/logo"
                 :class="sidebarExpanded ? 'gap-3 px-4 py-4 justify-between' : 'px-2 py-4 justify-center'">

                {{-- Logo icon (Clickable in collapsed mode to expand) --}}
                <div @click="if(!sidebarExpanded) sidebarExpanded = true"
                     class="flex items-center gap-2.5 min-w-0 cursor-pointer"
                     :class="sidebarExpanded ? '' : 'justify-center w-full'">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#58967d] to-[#2c4d41] flex items-center justify-center text-white shadow-lg shadow-[#366050]/30 flex-shrink-0 group-hover/logo:scale-105 transition-all duration-300 border border-white/30 relative">
                        {{-- Standard Lightning Icon --}}
                        <svg class="w-5 h-5 transition-all duration-300"
                             :class="!sidebarExpanded ? 'group-hover/logo:opacity-0' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        {{-- Hover Expand Icon (appears in compressed mode on hover) --}}
                        <svg class="w-5 h-5 absolute inset-0 m-auto opacity-0 group-hover/logo:opacity-100 transition-opacity duration-200 text-white"
                             x-show="!sidebarExpanded"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <div x-show="sidebarExpanded" class="overflow-hidden">
                    <div class="font-extrabold text-sm tracking-tight text-[#1b382b] flex items-center gap-1.5 whitespace-nowrap">
                            Nexora <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full bg-[#58967d]/15 text-[#366050] border border-[#58967d]/20">CRM</span>
                        </div>
                        <p class="text-[10px] text-[#427863] font-medium tracking-wide whitespace-nowrap">Enterprise 2026</p>
                    </div>
                </div>

                {{-- Collapse toggle button --}}
                <button @click.stop="sidebarExpanded = !sidebarExpanded"
                        x-show="sidebarExpanded"
                        class="flex-shrink-0 w-6 h-6 rounded-lg glass-pill flex items-center justify-center text-[#427863] hover:text-[#1b382b] hover:bg-white/50 transition-all duration-200"
                        title="Collapse sidebar">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- Expand toggle pill --}}
                <button @click.stop="sidebarExpanded = !sidebarExpanded"
                        x-show="!sidebarExpanded"
                        class="absolute -right-2.5 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full glass-panel flex items-center justify-center text-[#1b382b] hover:bg-white shadow-md border border-white/70 opacity-0 group-hover/logo:opacity-100 transition-all duration-200 z-20"
                        title="Expand sidebar"
                        style="display:none;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            {{-- ── NAV LINKS ── --}}
            <div class="flex-1 overflow-y-auto overflow-x-hidden py-3 space-y-1 no-scrollbar"
                 :class="sidebarExpanded ? 'px-2.5' : 'px-2'">

                {{-- Section: Core Apps --}}
                <div class="px-2 pb-1 pt-2 text-[9px] font-bold uppercase tracking-widest text-[#427863]/70"
                     x-show="sidebarExpanded">Core Apps</div>

                @php
                    $pageRoute = fn (string $route): string => $isDemo ? route('demo.'.$route) : route($route);
                    $navItems = [
                        ['route' => 'dashboard',   'label' => 'Dashboard',           'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'badge' => null,           'section' => 'core'],
                        ['route' => 'leads',        'label' => 'Leads',               'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'badge' => '24',          'section' => 'core'],
                        ['route' => 'contacts',     'label' => 'Contacts',            'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'badge' => null,           'section' => 'core'],
                        ['route' => 'companies',    'label' => 'Companies',           'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V5', 'badge' => null,           'section' => 'core'],
                        ['route' => 'deals',        'label' => 'Deals',               'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'badge' => null,           'section' => 'core'],
                        ['route' => 'pipeline',     'label' => 'Pipeline',            'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'badge' => null,           'section' => 'core'],
                    ];
                    $productivityItems = [
                        ['route' => 'tasks',        'label' => 'Tasks',               'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'badge' => '5',           'section' => 'prod'],
                        ['route' => 'calendar',     'label' => 'Calendar',            'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'badge' => null,           'section' => 'prod'],
                        ['route' => 'activities',   'label' => 'Activities',          'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'badge' => null,           'section' => 'prod'],
                    ];
                    $systemItems = [
                        ['route' => 'expenses',     'label' => 'Expenses',            'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'badge' => null, 'section' => 'sys'],
                        ['route' => 'automation',   'label' => 'Automation',          'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'badge' => null,           'section' => 'sys'],
                        ['route' => 'team',         'label' => 'Team',                'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'badge' => null,           'section' => 'sys'],
                        ['route' => 'settings',     'label' => 'Settings',            'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'badge' => null,           'section' => 'sys'],
                    ];
                    $enabledModules = $enabledModules ?? request()->attributes->get('enabledModules', []);
                    $isSuperAdmin = auth()->user()?->isSuperAdmin() ?? false;
                    $moduleIsEnabled = fn (array $item): bool => $isSuperAdmin || ($enabledModules[$item['route']] ?? true);
                    $navItems = array_values(array_filter($navItems, $moduleIsEnabled));
                    $productivityItems = array_values(array_filter($productivityItems, $moduleIsEnabled));
                    $systemItems = array_values(array_filter($systemItems, $moduleIsEnabled));
                @endphp

                @if(auth()->user()?->isSuperAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="mb-2 flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-bold {{ request()->routeIs('admin.*') ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/30' }}">Super Admin</a>
                @endif

                @if(request()->routeIs('admin.*'))
                    @php($navItems = [])
                    @php($productivityItems = [])
                    @php($systemItems = [])
                @endif

                @foreach($navItems as $item)
                    <a href="{{ $pageRoute($item['route']) }}"
                       class="flex items-center rounded-xl font-medium text-xs transition-all duration-200 group relative
                              {{ request()->routeIs(($isDemo ? 'demo.' : '').$item['route']) ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/30 hover:text-[#1b382b]' }}"
                       :class="sidebarExpanded ? 'gap-3 px-3 py-2.5 justify-between' : 'justify-center p-2.5'"
                       title="{{ $item['label'] }}">
                        <div class="flex items-center" :class="sidebarExpanded ? 'gap-3' : 'justify-center'">
                            <svg class="w-[18px] h-[18px] flex-shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                            </svg>
                            <span x-show="sidebarExpanded" class="truncate">{{ $item['label'] }}</span>
                        </div>
                        @if($item['badge'])
                            <span x-show="sidebarExpanded" class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full font-bold
                                         {{ $currentRoute == $item['route'] ? 'bg-white/20 text-white' : 'bg-[#58967d]/15 text-[#366050]' }}">
                                {{ $item['badge'] }}
                            </span>
                        @endif
                        {{-- Tooltip for collapsed mode --}}
                        <span x-show="!sidebarExpanded"
                              class="absolute left-full ml-3 px-2.5 py-1 glass-tooltip rounded-lg text-[11px] font-semibold whitespace-nowrap opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 z-50"
                              style="display:none;">{{ $item['label'] }}</span>
                    </a>
                @endforeach

                {{-- Productivity section --}}
                <div class="px-2 pb-1 pt-3 text-[9px] font-bold uppercase tracking-widest text-[#427863]/70"
                     x-show="sidebarExpanded">Productivity</div>

                <div class="my-2 mx-auto w-6 h-px bg-white/30" x-show="!sidebarExpanded"></div>

                @foreach($productivityItems as $item)
                    <a href="{{ $pageRoute($item['route']) }}"
                       class="flex items-center rounded-xl font-medium text-xs transition-all duration-200 group relative
                              {{ request()->routeIs(($isDemo ? 'demo.' : '').$item['route']) ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/30 hover:text-[#1b382b]' }}"
                       :class="sidebarExpanded ? 'gap-3 px-3 py-2.5 justify-between' : 'justify-center p-2.5'"
                       title="{{ $item['label'] }}">
                        <div class="flex items-center" :class="sidebarExpanded ? 'gap-3' : 'justify-center'">
                            <svg class="w-[18px] h-[18px] flex-shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                            </svg>
                            <span x-show="sidebarExpanded" class="truncate">{{ $item['label'] }}</span>
                        </div>
                        @if($item['badge'])
                            <span x-show="sidebarExpanded" class="flex-shrink-0 text-[10px] px-1.5 py-0.5 rounded-full font-bold bg-[#58967d]/15 text-[#366050] border border-[#58967d]/20">
                                {{ $item['badge'] }} Due
                            </span>
                        @endif
                        <span x-show="!sidebarExpanded"
                              class="absolute left-full ml-3 px-2.5 py-1 glass-tooltip rounded-lg text-[11px] font-semibold whitespace-nowrap opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 z-50"
                              style="display:none;">{{ $item['label'] }}</span>
                    </a>
                @endforeach

                {{-- System section --}}
                <div class="px-2 pb-1 pt-3 text-[9px] font-bold uppercase tracking-widest text-[#427863]/70"
                     x-show="sidebarExpanded">Insights & System</div>

                @foreach($systemItems as $item)
                    <a href="{{ $pageRoute($item['route']) }}"
                       class="flex items-center rounded-xl font-medium text-xs transition-all duration-200 group relative
                              {{ request()->routeIs(($isDemo ? 'demo.' : '').$item['route']) ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/30 hover:text-[#1b382b]' }}"
                       :class="sidebarExpanded ? 'gap-3 px-3 py-2.5' : 'justify-center p-2.5'"
                       title="{{ $item['label'] }}">
                        <svg class="w-[18px] h-[18px] flex-shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                        <span x-show="sidebarExpanded" class="truncate">{{ $item['label'] }}</span>
                        <span x-show="!sidebarExpanded"
                              class="absolute left-full ml-3 px-2.5 py-1 glass-tooltip rounded-lg text-[11px] font-semibold whitespace-nowrap opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 z-50"
                              style="display:none;">{{ $item['label'] }}</span>
                    </a>
                @endforeach

                @if($isSuperAdmin || ($enabledModules['reports'] ?? true))
                    <div x-data="{ reportsOpen: {{ request()->routeIs(($isDemo ? 'demo.' : '').'reports*') ? 'true' : 'false' }} }">
                        <button type="button" @click="sidebarExpanded = true; reportsOpen = !reportsOpen"
                                class="flex w-full items-center rounded-xl text-left text-xs font-medium transition-all duration-200 {{ request()->routeIs(($isDemo ? 'demo.' : '').'reports*') ? 'glass-nav-active' : 'text-[#2c4d41] hover:bg-white/30' }}"
                                :class="sidebarExpanded ? 'gap-3 px-3 py-2.5 justify-between' : 'justify-center p-2.5'"
                                title="Reports">
                            <span class="flex items-center gap-3">
                                <svg class="h-[18px] w-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                                <span x-show="sidebarExpanded">Reports</span>
                            </span>
                            <svg x-show="sidebarExpanded" class="h-3 w-3 transition-transform" :class="reportsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="reportsOpen && sidebarExpanded" x-transition class="ml-8 mt-1 space-y-1 border-l border-emerald-900/15 pl-3">
                            @foreach ([['daily', 'Daily report'], ['monthly', 'Monthly report'], ['tasks', 'Task report'], ['activities', 'Activity report']] as [$reportRoute, $reportLabel])
                                <a href="{{ route(($isDemo ? 'demo.' : '').'reports.'.$reportRoute) }}" class="block rounded-lg px-2 py-1.5 text-[10px] font-semibold {{ request()->routeIs(($isDemo ? 'demo.' : '').'reports.'.$reportRoute) ? 'bg-emerald-900/10 text-emerald-950' : 'text-[#365b4c] hover:bg-white/60' }}">{{ $reportLabel }}</a>
                            @endforeach
                            <a href="{{ route(($isDemo ? 'demo.' : '').'reports.modules') }}" class="block rounded-lg px-2 py-1.5 text-[10px] font-semibold {{ request()->routeIs(($isDemo ? 'demo.' : '').'reports.module*') ? 'bg-emerald-900/10 text-emerald-950' : 'text-[#365b4c] hover:bg-white/60' }}">Module reports</a>
                        </div>
                    </div>
                @endif

            </div>

            {{-- ── BOTTOM USER CARD ── --}}
            <div class="border-t border-white/30 flex-shrink-0"
                 :class="sidebarExpanded ? 'p-3' : 'p-2'">

                {{-- BrosTech badge --}}
                <div x-show="sidebarExpanded" class="mb-2 text-center">
                    <span class="text-[9px] font-bold text-[#427863]/60 tracking-widest uppercase">Powered by BrosTech</span>
                </div>

                <div class="rounded-xl glass-row flex items-center group hover:bg-white/35 transition-all cursor-pointer"
                     :class="sidebarExpanded ? 'p-2.5 gap-3 justify-between' : 'p-2 justify-center'">
                    <div class="flex items-center" :class="sidebarExpanded ? 'gap-2.5' : 'justify-center'">
                        <div class="relative flex-shrink-0">
                            <img class="w-8 h-8 rounded-xl object-cover ring-2 ring-[#58967d]/25"
                                 src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=256"
                                 alt="Olivia Carter">
                            <span class="absolute bottom-0 right-0 w-2 h-2 bg-emerald-500 border border-white rounded-full animate-pulse-glow"></span>
                        </div>
                        <div x-show="sidebarExpanded" class="min-w-0">
                            <div class="font-bold text-[11px] text-[#1b382b] truncate">{{ auth()->user()?->name ?? 'Demo Visitor' }}</div>
                            <div class="text-[10px] text-[#427863] font-medium truncate">{{ $isDemo ? 'Demo Workspace' : (auth()->user()?->isSuperAdmin() ? 'Super Admin' : 'Admin') }}</div>
                        </div>
                    </div>
                    <form action="{{ $isDemo ? route('demo.exit') : route('logout') }}" method="POST" x-show="sidebarExpanded">
                        @csrf
                        <button type="submit" title="{{ $isDemo ? 'Exit Demo' : 'Sign Out' }}" class="text-[#427863] hover:text-rose-600 p-1 rounded-lg hover:bg-rose-50/50 flex-shrink-0 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>
        @endif

        {{-- ══════════════════════════════════════
             MAIN CONTENT AREA
        ══════════════════════════════════════ --}}
        <main class="flex-1 flex flex-col h-full min-w-0 overflow-hidden relative transition-all duration-300"
              :style="$store ? '' : ''"
              :class="{
                  'ml-[236px]': sidebarExpanded && '{{ $currentRoute }}' !== 'login',
                  'ml-[76px]': !sidebarExpanded && '{{ $currentRoute }}' !== 'login',
                  'ml-0': '{{ $currentRoute }}' === 'login'
              }">

            @if($currentRoute !== 'login')
            {{-- ── TOP HEADER BAR ── --}}
            <header class="h-14 glass-header mx-3 mt-3 rounded-2xl px-5 flex items-center justify-between gap-4 z-20 flex-shrink-0"
                    style="box-shadow: 0 4px 24px rgba(27,56,43,0.08), 0 1px 0 rgba(255,255,255,0.7) inset;">

                {{-- Left: Mobile menu + Search --}}
                <div class="flex items-center gap-3 flex-1 max-w-md">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                            class="md:hidden p-1.5 text-[#2c4d41] rounded-xl glass-pill">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div class="relative w-full cursor-pointer" @click="searchModalOpen = true">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#427863]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" readonly
                               placeholder="Search contacts, deals, companies..."
                               class="w-full pl-9 pr-12 py-1.5 text-[11px] font-medium rounded-xl glass-input text-[#1b382b] placeholder-[#427863]/60 cursor-pointer">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <kbd class="px-1.5 py-0.5 text-[10px] font-bold text-[#427863] bg-white/60 border border-white/80 rounded shadow-xs">⌘K</kbd>
                        </div>
                    </div>
                </div>

                {{-- Right: Actions --}}
                <div class="flex items-center gap-2">

                    @if($isDemo)
                        <span class="hidden md:inline-flex rounded-full border border-amber-400/50 bg-amber-100/90 px-2.5 py-1 text-[10px] font-bold text-amber-950">DEMO · private browser workspace · activity is logged anonymously</span>
                    @endif

                    {{-- Workspace --}}
                    <div class="relative" x-data="{ filterOpen: false, activeWorkspace: 'Global Enterprise' }">
                        <button @click="filterOpen = !filterOpen"
                                class="hidden sm:flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl glass-pill text-[11px] font-semibold text-[#1b382b] cursor-pointer hover:bg-white/40 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#58967d] animate-pulse-glow"></span>
                            <span x-text="activeWorkspace">{{ $isDemo ? 'Demo Workspace' : 'Global Enterprise' }}</span>
                            <svg class="w-3 h-3 text-[#427863] transition-transform duration-200" :class="filterOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="filterOpen" @click.outside="filterOpen = false"
                             class="absolute right-0 mt-2 w-56 rounded-2xl glass-panel p-2 shadow-2xl z-50 animate-fade-in text-xs"
                             style="display:none;">
                            <div class="px-2 py-1.5 text-[10px] font-bold uppercase tracking-wider text-[#427863] border-b border-white/30 mb-1">Select Enterprise Division</div>
                            <template x-for="ws in ['Global Enterprise', 'North America Sales', 'EMEA Division', 'APAC Operations', 'UK & Ireland Regional']">
                                <button @click="activeWorkspace = ws; filterOpen = false"
                                        class="w-full text-left px-3 py-2 rounded-xl flex items-center justify-between hover:bg-white/40 font-medium text-[#1b382b] transition-colors"
                                        :class="activeWorkspace === ws ? 'bg-white/50 font-bold text-[#1b382b]' : ''">
                                    <span x-text="ws"></span>
                                    <svg x-show="activeWorkspace === ws" class="w-3.5 h-3.5 text-[#58967d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Date filter --}}
                    <div class="hidden lg:flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl glass-pill text-[11px] font-semibold text-[#1b382b]">
                        <svg class="w-3 h-3 text-[#427863]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>This Month</span>
                    </div>

                    {{-- New Record button --}}
                    <button @click="quickModalOpen = true" @if($isDemo) disabled title="Demo-only" @endif
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-[11px] font-bold shadow-md shadow-[#366050]/25 hover:brightness-110 active:scale-95 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden sm:inline">New Record</span>
                    </button>

                    {{-- Notifications --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="p-1.5 rounded-xl glass-pill text-[#2c4d41] hover:bg-white/50 transition-colors relative">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-emerald-500 rounded-full border border-white ring-1 ring-emerald-400 animate-pulse"></span>
                        </button>

                        <div x-show="open" @click.outside="open = false"
                             class="absolute right-0 mt-2 w-80 rounded-2xl glass-panel p-4 shadow-2xl z-50 animate-fade-in"
                             style="display:none;">
                            <div class="flex items-center justify-between border-b border-white/40 pb-2 mb-3">
                                <h4 class="font-bold text-xs text-[#1b382b]">Notifications</h4>
                                <span class="text-[10px] text-[#58967d] font-bold bg-[#58967d]/10 px-2 py-0.5 rounded-full">3 Unread</span>
                            </div>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                <div class="p-2.5 rounded-xl glass-row text-xs">
                                    <div class="font-semibold text-[#1b382b]">Deal Proposal Accepted</div>
                                    <div class="text-[11px] text-[#427863] mt-0.5">Acme Corp approved $45,000 agreement</div>
                                    <div class="text-[9px] text-[#58967d] mt-1 font-medium">10 mins ago</div>
                                </div>
                                <div class="p-2.5 rounded-xl glass-row text-xs">
                                    <div class="font-semibold text-[#1b382b]">New Inbound Lead</div>
                                    <div class="text-[11px] text-[#427863] mt-0.5">Marcus Brody registered via Website Demo</div>
                                    <div class="text-[9px] text-[#58967d] mt-1 font-medium">45 mins ago</div>
                                </div>
                                <div class="p-2.5 rounded-xl glass-row text-xs">
                                    <div class="font-semibold text-[#1b382b]">Task Overdue Alert</div>
                                    <div class="text-[11px] text-[#427863] mt-0.5">Follow-up with Vanguard Capital is overdue</div>
                                    <div class="text-[9px] text-rose-500 mt-1 font-medium">2 hours ago</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Settings icon --}}
                    @if($isSuperAdmin || ($enabledModules['settings'] ?? true))
                    <a href="{{ $pageRoute('settings') }}"
                       class="p-1.5 rounded-xl glass-pill text-[#2c4d41] hover:bg-white/50 transition-colors"
                       title="Settings">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </a>
                    @endif

                </div>
            </header>
            @endif

            {{-- ── PAGE CONTENT ── --}}
            <div class="flex-1 overflow-y-auto p-3 pt-3 space-y-4">
                @yield('content')

                @if($isDemo && isset($demoRecords, $demoModule))
                    @include('crm.partials.demo-records')
                @endif

                {{-- BrosTech footer --}}
                @if($currentRoute !== 'login')
                <div class="pb-2 text-center">
                    <span class="text-[9px] text-[#427863]/50 font-semibold tracking-widest uppercase">Nexora CRM &bull; Powered by BrosTech &bull; &copy; {{ date('Y') }}</span>
                </div>
                @endif
            </div>

        </main>
    </div>

    {{-- ══════════════════════════════════════
         QUICK CREATE MODAL
    ══════════════════════════════════════ --}}
    <div x-show="quickModalOpen"
         x-data="{ recordType: 'Lead' }"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/35 backdrop-blur-sm"
         style="display:none;">
        <div @click.outside="quickModalOpen = false"
             class="w-full max-w-lg glass-panel p-6 rounded-3xl shadow-2xl animate-fade-in border border-white/60">
            <div class="flex items-center justify-between border-b border-white/40 pb-3 mb-4">
                <h3 class="font-bold text-sm text-[#1b382b] flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#58967d]"></span>
                    Create New CRM Record
                </h3>
                <button @click="quickModalOpen = false" class="text-[#427863] hover:text-[#1b382b] p-1 rounded-lg hover:bg-white/40 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-[11px] font-bold text-[#2c4d41] mb-1.5 uppercase tracking-wider">Record Type</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" @click="recordType = 'Lead'"
                                :class="recordType === 'Lead' ? 'glass-nav-active text-white shadow-md' : 'glass-pill text-[#2c4d41] hover:bg-white/50'"
                                class="py-2 px-3 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Lead
                        </button>
                        <button type="button" @click="recordType = 'Deal'"
                                :class="recordType === 'Deal' ? 'glass-nav-active text-white shadow-md' : 'glass-pill text-[#2c4d41] hover:bg-white/50'"
                                class="py-2 px-3 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Deal
                        </button>
                        <button type="button" @click="recordType = 'Contact'"
                                :class="recordType === 'Contact' ? 'glass-nav-active text-white shadow-md' : 'glass-pill text-[#2c4d41] hover:bg-white/50'"
                                class="py-2 px-3 text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Contact
                        </button>
                    </div>
                </div>

                {{-- Lead Dynamic Form --}}
                <div x-show="recordType === 'Lead'" class="space-y-3 animate-fade-in">
                    <div>
                        <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Lead Full Name</label>
                        <input type="text" placeholder="e.g. Eleanor Vance" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Company</label>
                            <input type="text" placeholder="Apex Logistics" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Estimated Value ($)</label>
                            <input type="number" placeholder="45,000" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Lead Source</label>
                        <select class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                            <option>Website Contact Form</option>
                            <option>LinkedIn Inbound</option>
                            <option>Referral Partner</option>
                            <option>Cold Outreach</option>
                        </select>
                    </div>
                </div>

                {{-- Deal Dynamic Form --}}
                <div x-show="recordType === 'Deal'" class="space-y-3 animate-fade-in" style="display:none;">
                    <div>
                        <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Deal Title / Opportunity</label>
                        <input type="text" placeholder="e.g. Enterprise Software License 2026" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Company Account</label>
                            <input type="text" placeholder="Vanguard Capital" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Deal Value ($)</label>
                            <input type="number" placeholder="180,000" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Pipeline Stage</label>
                        <select class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                            <option>New Lead</option>
                            <option>Qualification</option>
                            <option>Proposal Sent</option>
                            <option selected>Negotiation</option>
                            <option>Closed Won</option>
                        </select>
                    </div>
                </div>

                {{-- Contact Dynamic Form --}}
                <div x-show="recordType === 'Contact'" class="space-y-3 animate-fade-in" style="display:none;">
                    <div>
                        <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Contact Person Name</label>
                        <input type="text" placeholder="e.g. Marcus Brody" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Email Address</label>
                            <input type="email" placeholder="marcus@horizon.com" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Phone Number</label>
                            <input type="text" placeholder="+1 (555) 234-5678" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[#2c4d41] mb-1 uppercase tracking-wider">Company & Job Title</label>
                        <input type="text" placeholder="Horizon Robotics — VP of Operations" class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#2c4d41] mb-1.5 uppercase tracking-wider">Assigned Owner</label>
                    <select class="w-full px-3.5 py-2.5 rounded-xl glass-input text-xs font-medium text-[#1b382b]">
                        <option>Olivia Carter (Sales Director)</option>
                        <option>Michael Lee (Senior AE)</option>
                        <option>Sarah Kim (Account Manager)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-white/30">
                    <button type="button" @click="quickModalOpen = false"
                            class="px-4 py-2.5 rounded-xl text-xs font-semibold text-[#427863] hover:bg-white/40 transition-colors">
                        Cancel
                    </button>
                    <button type="button" @click="quickModalOpen = false"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#58967d] to-[#366050] text-white text-xs font-bold shadow-md shadow-[#366050]/20 hover:brightness-110 active:scale-95 transition-all">
                        Save <span x-text="recordType"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         GLOBAL COMMAND SEARCH PALETTE (Ctrl+K)
    ══════════════════════════════════════ --}}
    <div x-show="searchModalOpen"
         class="fixed inset-0 z-50 flex items-start justify-center pt-20 p-4 bg-black/40 backdrop-blur-sm"
         style="display:none;">
        <div @click.outside="searchModalOpen = false"
             class="w-full max-w-xl glass-panel p-4 rounded-3xl shadow-2xl animate-fade-in border border-white/70">
            <div class="relative flex items-center border-b border-white/50 pb-3">
                <svg class="w-5 h-5 text-[#58967d] ml-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" autofocus
                       placeholder="Type a command or search Nexora CRM..."
                       class="w-full pl-3 pr-4 py-1 text-sm font-semibold bg-transparent text-[#1b382b] focus:outline-none placeholder-[#427863]/60">
                <kbd class="flex-shrink-0 px-2 py-0.5 text-[10px] font-bold text-[#427863] bg-white/60 border border-white/80 rounded-md">ESC</kbd>
            </div>
            <div class="mt-3 space-y-0.5 text-xs">
                <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-[#427863]">Quick Navigation</div>
                <a href="{{ $isDemo ? route('demo.leads') : route('leads') }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-white/35 text-[#1b382b] font-medium transition-colors">
                    <span class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-[#58967d]/15 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-[#366050]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        Go to Leads Pipeline
                    </span>
                    <span class="text-[10px] text-[#58967d] glass-pill px-2 py-0.5 rounded-md">L</span>
                </a>
                <a href="{{ $isDemo ? route('demo.contacts') : route('contacts') }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-white/35 text-[#1b382b] font-medium transition-colors">
                    <span class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-blue-500/10 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        View Customer Contacts
                    </span>
                    <span class="text-[10px] text-[#58967d] glass-pill px-2 py-0.5 rounded-md">C</span>
                </a>
                <a href="{{ $isDemo ? route('demo.reports') : route('reports') }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-white/35 text-[#1b382b] font-medium transition-colors">
                    <span class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-purple-500/10 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                        </span>
                        Open Revenue Reports
                    </span>
                    <span class="text-[10px] text-[#58967d] glass-pill px-2 py-0.5 rounded-md">R</span>
                </a>
                <a href="{{ $isDemo ? route('demo.deals') : route('deals') }}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-white/35 text-[#1b382b] font-medium transition-colors">
                    <span class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-amber-500/10 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        Deals & Opportunities
                    </span>
                    <span class="text-[10px] text-[#58967d] glass-pill px-2 py-0.5 rounded-md">D</span>
                </a>
            </div>
        </div>
    </div>

    @if ($isDemo)
        <script>
            document.addEventListener('click', (event) => {
                const control = event.target instanceof Element
                    ? event.target.closest('a[href], button, [role="button"]')
                    : null;

                if (!control || control.disabled || control.closest('form')) {
                    return;
                }

                const action = (control.dataset.demoAction || control.getAttribute('aria-label') || control.getAttribute('title') || control.innerText || '')
                    .replace(/\s+/g, ' ')
                    .trim()
                    .slice(0, 120);

                if (!action) {
                    return;
                }

                fetch(@json(route('demo.activity')), {
                    method: 'POST',
                    credentials: 'same-origin',
                    keepalive: true,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token()),
                    },
                    body: JSON.stringify({ page: @json($demoPage), action }),
                }).catch(() => {});
            });
        </script>
    @endif
</body>
</html>

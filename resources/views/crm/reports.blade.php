@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="space-y-4 animate-fade-in">

    {{-- PAGE HEADER --}}
    <div class="glass-card kpi-accent-purple p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-[#1b382b] flex items-center gap-2">
                Reports & Executive Analytics
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-800 font-bold border border-emerald-500/20 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse inline-block"></span>
                    Live Intelligence
                </span>
            </h1>
            <p class="text-xs text-[#427863] mt-0.5">Comprehensive sales metrics, conversion funnels, and revenue forecasting — powered by BrosTech.</p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <select class="px-3 py-1.5 text-xs font-semibold rounded-xl glass-input text-[#1b382b]">
                <option>All Regions</option>
                <option>North America</option>
                <option>EMEA</option>
                <option>APAC</option>
            </select>
            <select class="px-3 py-1.5 text-xs font-semibold rounded-xl glass-input text-[#1b382b]">
                <option>Q3 2026</option>
                <option>Q2 2026</option>
                <option>Full Year 2026</option>
            </select>
            <button class="px-3 py-1.5 rounded-xl glass-pill text-xs font-bold text-[#2c4d41] hover:bg-white/50 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
            </button>
        </div>
    </div>

    {{-- REPORT KPI ROW --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
        @php
            $reportKpis = [
                ['label' => 'Total Revenue', 'value' => '$803K', 'change' => '+32% YoY', 'up' => true, 'color' => 'kpi-accent-emerald', 'bg' => 'bg-[#58967d]/15 text-[#366050]', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Total Deals', 'value' => '189', 'change' => '+24 vs Q2', 'up' => true, 'color' => 'kpi-accent-blue', 'bg' => 'bg-blue-500/15 text-blue-700', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['label' => 'Win Rate', 'value' => '64.3%', 'change' => '+8.1% vs Q2', 'up' => true, 'color' => 'kpi-accent-teal', 'bg' => 'bg-teal-500/15 text-teal-700', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                ['label' => 'Avg Cycle', 'value' => '28 days', 'change' => '-4 days vs Q2', 'up' => true, 'color' => 'kpi-accent-amber', 'bg' => 'bg-amber-500/15 text-amber-700', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Churn Rate', 'value' => '1.6%', 'change' => '-0.4% vs Q2', 'up' => true, 'color' => 'kpi-accent-rose', 'bg' => 'bg-rose-500/15 text-rose-700', 'icon' => 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6'],
            ];
        @endphp
        @foreach($reportKpis as $kpi)
        <div class="glass-card {{ $kpi['color'] }} p-4">
            <div class="w-8 h-8 rounded-xl {{ $kpi['bg'] }} flex items-center justify-center mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $kpi['icon'] }}"/></svg>
            </div>
            <div class="text-[10px] font-bold text-[#427863] uppercase tracking-wider">{{ $kpi['label'] }}</div>
            <div class="text-xl font-extrabold text-[#1b382b] mt-0.5">{{ $kpi['value'] }}</div>
            <div class="text-[10px] text-emerald-700 mt-1 font-semibold">{{ $kpi['change'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- MAIN CHARTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

        {{-- Revenue Bar Chart (7 cols) --}}
        <div class="lg:col-span-7 glass-card p-5">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-4">
                <div>
                    <h3 class="font-extrabold text-sm text-[#1b382b]">Monthly Revenue Growth</h3>
                    <p class="text-[10px] text-[#427863]">YTD quarterly breakdown 2026</p>
                </div>
                <span class="text-xs font-bold text-emerald-700 bg-emerald-500/10 px-2 py-1 rounded-xl">+32% YoY</span>
            </div>
            <div class="h-56 w-full relative">
                <canvas id="reportsRevenueChart"></canvas>
            </div>
        </div>

        {{-- Lead Source Pie (5 cols) --}}
        <div class="lg:col-span-5 glass-card p-5">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-4">
                <div>
                    <h3 class="font-extrabold text-sm text-[#1b382b]">Lead Acquisition Sources</h3>
                    <p class="text-[10px] text-[#427863]">Top channel: Website Inbound (42%)</p>
                </div>
            </div>
            <div class="h-56 w-full relative">
                <canvas id="reportsLeadSourceChart"></canvas>
            </div>
        </div>

    </div>

    {{-- CONVERSION FUNNEL + MONTHLY BREAKDOWN TABLE --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

        {{-- Conversion Funnel (5 cols) --}}
        <div class="lg:col-span-5 glass-card p-5">
            <div class="flex items-center justify-between border-b border-white/30 pb-3 mb-4">
                <h3 class="font-extrabold text-sm text-[#1b382b]">Conversion Funnel</h3>
                <span class="text-[11px] font-bold text-[#427863]">Lead → Close</span>
            </div>
            <div class="space-y-2">
                @php
                    $funnel = [
                        ['stage' => 'Total Leads', 'count' => 1284, 'pct' => 100, 'color' => 'bg-gradient-to-r from-[#58967d] to-[#7eb39b]'],
                        ['stage' => 'Qualified', 'count' => 642, 'pct' => 50, 'color' => 'bg-gradient-to-r from-blue-600 to-blue-400'],
                        ['stage' => 'Proposal Sent', 'count' => 320, 'pct' => 25, 'color' => 'bg-gradient-to-r from-purple-700 to-purple-500'],
                        ['stage' => 'In Negotiation', 'count' => 142, 'pct' => 11, 'color' => 'bg-gradient-to-r from-amber-600 to-amber-400'],
                        ['stage' => 'Deals Closed Won', 'count' => 64, 'pct' => 5, 'color' => 'bg-gradient-to-r from-emerald-700 to-emerald-500'],
                    ];
                @endphp
                @foreach($funnel as $row)
                <div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="font-semibold text-[#1b382b]">{{ $row['stage'] }}</span>
                        <span class="font-extrabold text-[#1b382b]">{{ number_format($row['count']) }} <span class="text-[#427863] font-medium">({{ $row['pct'] }}%)</span></span>
                    </div>
                    <div class="h-2 rounded-full bg-white/25">
                        <div class="{{ $row['color'] }} h-2 rounded-full transition-all duration-700" style="width: {{ $row['pct'] }}%;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Monthly Performance Table (7 cols) --}}
        <div class="lg:col-span-7 glass-card overflow-hidden">
            <div class="flex items-center justify-between border-b border-white/30 p-5 pb-3">
                <div>
                    <h3 class="font-extrabold text-sm text-[#1b382b]">Monthly Performance Breakdown</h3>
                    <p class="text-[10px] text-[#427863]">Revenue, deals and conversion by month</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs glass-table">
                    <thead>
                        <tr class="text-[#427863] font-bold uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-4 text-left">Month</th>
                            <th class="py-3 px-4 text-right">Revenue</th>
                            <th class="py-3 px-4 text-right">Deals Won</th>
                            <th class="py-3 px-4 text-right">Leads In</th>
                            <th class="py-3 px-4 text-right">Conv. Rate</th>
                            <th class="py-3 px-4 text-right">Growth</th>
                        </tr>
                    </thead>
                    <tbody class="text-[#1b382b]">
                        @php
                            $months = [
                                ['month' => 'Jan 2026', 'rev' => '$45,000', 'deals' => 8, 'leads' => 180, 'conv' => '12.4%', 'growth' => '+18%', 'up' => true],
                                ['month' => 'Feb 2026', 'rev' => '$52,000', 'deals' => 11, 'leads' => 210, 'conv' => '14.2%', 'growth' => '+15%', 'up' => true],
                                ['month' => 'Mar 2026', 'rev' => '$68,000', 'deals' => 14, 'leads' => 248, 'conv' => '15.8%', 'growth' => '+31%', 'up' => true],
                                ['month' => 'Apr 2026', 'rev' => '$74,000', 'deals' => 15, 'leads' => 265, 'conv' => '16.3%', 'growth' => '+9%', 'up' => true],
                                ['month' => 'May 2026', 'rev' => '$89,000', 'deals' => 18, 'leads' => 294, 'conv' => '17.2%', 'growth' => '+20%', 'up' => true],
                                ['month' => 'Jun 2026', 'rev' => '$95,000', 'deals' => 19, 'leads' => 310, 'conv' => '17.8%', 'growth' => '+7%', 'up' => true],
                                ['month' => 'Jul 2026', 'rev' => '$110,000', 'deals' => 22, 'leads' => 328, 'conv' => '18.2%', 'growth' => '+16%', 'up' => true],
                                ['month' => 'Aug 2026', 'rev' => '$128,000', 'deals' => 26, 'leads' => 342, 'conv' => '18.9%', 'growth' => '+16%', 'up' => true],
                                ['month' => 'Sep 2026', 'rev' => '$86,240', 'deals' => 12, 'leads' => 142, 'conv' => '18.4%', 'growth' => 'MTD', 'up' => true],
                            ];
                        @endphp
                        @foreach($months as $row)
                        <tr class="{{ $loop->last ? 'bg-[#58967d]/08' : '' }}">
                            <td class="py-2.5 px-4 font-semibold {{ $loop->last ? 'text-[#58967d] font-bold' : '' }}">{{ $row['month'] }}</td>
                            <td class="py-2.5 px-4 text-right font-extrabold">{{ $row['rev'] }}</td>
                            <td class="py-2.5 px-4 text-right">{{ $row['deals'] }}</td>
                            <td class="py-2.5 px-4 text-right text-[#427863]">{{ $row['leads'] }}</td>
                            <td class="py-2.5 px-4 text-right text-[#427863]">{{ $row['conv'] }}</td>
                            <td class="py-2.5 px-4 text-right">
                                <span class="font-bold {{ $row['up'] ? 'text-emerald-700' : 'text-rose-600' }}">{{ $row['growth'] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const ctxRev = document.getElementById('reportsRevenueChart')?.getContext('2d');
    if (ctxRev) {
        new Chart(ctxRev, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [45000, 52000, 68000, 74000, 89000, 95000, 110000, 128000, 86240],
                    backgroundColor: (ctx) => {
                        const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                        g.addColorStop(0, '#58967d');
                        g.addColorStop(1, 'rgba(88,150,125,0.3)');
                        return g;
                    },
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(27,56,43,0.92)',
                        callbacks: { label: ctx => 'Revenue: $' + ctx.raw.toLocaleString() }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10, weight: '600' }, color: '#427863' } },
                    y: { grid: { color: 'rgba(200,220,210,0.25)' }, ticks: { font: { size: 10 }, color: '#427863', callback: v => '$' + (v / 1000) + 'k' } }
                }
            }
        });
    }

    const ctxSrc = document.getElementById('reportsLeadSourceChart')?.getContext('2d');
    if (ctxSrc) {
        new Chart(ctxSrc, {
            type: 'doughnut',
            data: {
                labels: ['Website Inbound', 'LinkedIn Outbound', 'Partner Referral', 'Events & Expos', 'Cold Email'],
                datasets: [{
                    data: [42, 24, 18, 10, 6],
                    backgroundColor: ['#58967d', '#366050', '#7eb39b', '#f59e0b', '#3b82f6'],
                    borderWidth: 3,
                    borderColor: 'rgba(255,255,255,0.5)',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { size: 11, weight: '600' }, color: '#427863', padding: 12, boxWidth: 10, borderRadius: 4 }
                    },
                    tooltip: { backgroundColor: 'rgba(27,56,43,0.92)' }
                }
            }
        });
    }

});
</script>
@endsection

@extends('layouts.app')

@section('title', 'Demo user '.$demoVisitor->id)

@section('content')
<div class="space-y-4 animate-fade-in">
    <div class="glass-card flex flex-wrap items-center justify-between gap-4 p-5">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-bold text-[#58967d] hover:underline">← Super Admin dashboard</a>
            <p class="mt-3 text-[10px] font-bold uppercase tracking-widest text-[#58967d]">Anonymous visitor activity</p>
            <h1 class="mt-1 text-xl font-extrabold text-[#1b382b]">Demo user {{ $demoVisitor->id }}</h1>
            <p class="mt-1 text-xs text-[#427863]">First seen {{ $firstSeenAt ? \Illuminate\Support\Carbon::parse($firstSeenAt)->format('M j, Y H:i') : $demoVisitor->created_at->format('M j, Y H:i') }}</p>
        </div>
        <span class="rounded-full px-3 py-1.5 text-[10px] font-bold {{ $activeSessions > 0 ? 'bg-emerald-500/15 text-emerald-800' : 'bg-slate-500/10 text-slate-600' }}">{{ $activeSessions > 0 ? 'Active now' : 'Inactive' }}</span>
    </div>

    <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">
        @foreach ([['Sessions', $demoVisitor->sessions_count], ['Page visits', $demoVisitor->page_views_count], ['Active sessions', $activeSessions], ['Browser identity', 'Demo user '.$demoVisitor->id]] as [$label, $value])
            <div class="glass-card p-4">
                <div class="text-[10px] font-bold uppercase tracking-wider text-[#427863]">{{ $label }}</div>
                <div class="mt-2 text-lg font-extrabold text-[#1b382b]">{{ is_numeric($value) ? number_format($value) : $value }}</div>
            </div>
        @endforeach
    </div>

    <section class="glass-card p-5">
        <div class="mb-3"><h2 class="text-sm font-extrabold text-[#1b382b]">Sessions</h2><p class="mt-1 text-[10px] text-[#427863]">Each row is one visit to the demo workspace.</p></div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[11px]">
                <thead class="text-[9px] font-bold uppercase tracking-wider text-[#427863]"><tr><th class="py-2">Started</th><th>Last active</th><th>Device</th><th>Page visits</th><th>Status</th></tr></thead>
                <tbody>
                @forelse ($sessions as $demoSession)
                    @php($isActive = $demoSession->ended_at === null && $demoSession->last_seen_at->gte(now()->subMinutes((int) config('demo.session_timeout_minutes', 30))))
                    <tr class="border-t border-white/30 text-[#1b382b]">
                        <td class="py-2.5">{{ $demoSession->started_at->format('M j, Y H:i') }}</td>
                        <td>{{ $demoSession->last_seen_at->diffForHumans() }}</td>
                        <td>{{ $demoSession->browser }} · {{ $demoSession->platform }}</td>
                        <td>{{ $demoSession->page_views_count }}</td>
                        <td><span class="rounded-full px-2 py-1 text-[9px] font-bold {{ $isActive ? 'bg-emerald-500/15 text-emerald-800' : 'bg-slate-500/10 text-slate-600' }}">{{ $isActive ? 'Active' : 'Ended' }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 text-center text-[#427863]">No sessions recorded.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $sessions->links() }}</div>
    </section>

    <section class="glass-card p-5">
        <div class="mb-3"><h2 class="text-sm font-extrabold text-[#1b382b]">Demo activity</h2><p class="mt-1 text-[10px] text-[#427863]">Pages opened and clicked control labels are recorded. Keystrokes and form values are never collected.</p></div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[11px]">
                <thead class="text-[9px] font-bold uppercase tracking-wider text-[#427863]"><tr><th class="py-2">Time</th><th>Event</th><th>Page</th><th>Clicked control</th><th>Session device</th></tr></thead>
                <tbody>
                @forelse ($activities as $activity)
                    <tr class="border-t border-white/30 text-[#1b382b]">
                        <td class="py-2.5 text-[#427863]">{{ $activity->created_at->format('M j, Y H:i:s') }}</td>
                        <td class="capitalize">{{ $activity->event }}</td>
                        <td>{{ $activity->page ?? '—' }}</td>
                        <td>{{ $activity->action ?? '—' }}</td>
                        <td class="text-[#427863]">{{ $activity->demoSession->browser }} · {{ $activity->demoSession->platform }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 text-center text-[#427863]">Activity will appear when this visitor uses the demo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $activities->links() }}</div>
    </section>
</div>
@endsection

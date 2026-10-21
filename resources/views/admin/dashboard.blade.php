@extends('layouts.app')

@section('title', 'Super Admin')

@section('content')
<div class="space-y-4 animate-fade-in">
    <div class="glass-card p-5 flex items-center justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-[#58967d]">Platform oversight</p>
            <h1 class="mt-1 text-xl font-extrabold text-[#1b382b]">Super Admin Dashboard</h1>
            <p class="mt-1 text-xs text-[#427863]">Demo visitors, workspace activity, and administrator access.</p>
        </div>
        <span class="rounded-full bg-emerald-500/15 px-3 py-1.5 text-[10px] font-bold text-emerald-800">Live overview</span>
    </div>

    @if (session('status'))
        <div class="glass-card border border-emerald-300 p-3 text-xs font-semibold text-emerald-800">{{ session('status') }}</div>
    @endif

    <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">
        @foreach ([['Active now', $activeSessions], ['Demo sessions', $totalSessions], ['Unique visitors', $uniqueVisitors], ['Page views today', $pageViewsToday]] as [$label, $value])
            <div class="glass-card p-4">
                <div class="text-[10px] font-bold uppercase tracking-wider text-[#427863]">{{ $label }}</div>
                <div class="mt-2 text-2xl font-extrabold text-[#1b382b]">{{ number_format($value) }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid gap-4 xl:grid-cols-3">
        <section class="glass-card p-5 xl:col-span-2">
            <div class="mb-4 flex items-center justify-between border-b border-white/40 pb-3">
                <div><h2 class="text-sm font-extrabold text-[#1b382b]">Demo sessions</h2><p class="mt-1 text-[10px] text-[#427863]">Active means a visitor was seen in the last {{ $timeout }} minutes.</p></div>
                <span class="text-[10px] font-bold text-[#58967d]">{{ $sessions->total() }} total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px]">
                    <thead class="text-[9px] font-bold uppercase tracking-wider text-[#427863]"><tr><th class="py-2">Visitor</th><th>Started</th><th>Last active</th><th>Device</th><th>Views</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse ($sessions as $demoSession)
                        <tr class="border-t border-white/30 text-[#1b382b]"><td class="py-2.5 font-semibold">@if ($demoSession->visitor)<a href="{{ route('admin.demo-users.show', $demoSession->visitor) }}" class="text-[#366050] hover:underline">Demo user {{ $demoSession->visitor->id }}</a>@else<span>Demo user {{ $demoSession->id }}</span>@endif</td><td>{{ $demoSession->started_at->format('M j, H:i') }}</td><td>{{ $demoSession->last_seen_at->diffForHumans() }}</td><td>{{ $demoSession->browser }} · {{ $demoSession->platform }}</td><td>{{ $demoSession->page_views_count }}</td><td><span class="rounded-full px-2 py-1 text-[9px] font-bold {{ $demoSession->ended_at === null && $demoSession->last_seen_at->gte(now()->subMinutes($timeout)) ? 'bg-emerald-500/15 text-emerald-800' : 'bg-slate-500/10 text-slate-600' }}">{{ $demoSession->ended_at === null && $demoSession->last_seen_at->gte(now()->subMinutes($timeout)) ? 'Active' : 'Ended' }}</span></td></tr>
                    @empty
                        <tr><td colspan="6" class="py-8 text-center text-[#427863]">No demo sessions yet. Share /demo to start collecting usage.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $sessions->links() }}</div>
        </section>

        <section class="glass-card p-5">
            <h2 class="text-sm font-extrabold text-[#1b382b]">Create administrator</h2>
            <p class="mt-1 text-[10px] text-[#427863]">Admins can use the CRM. Only you can access this dashboard.</p>
            <form action="{{ route('admin.admins.store') }}" method="POST" class="mt-4 space-y-3">
                @csrf
                <div><label class="mb-1 block text-[10px] font-bold text-[#2c4d41]">Full name</label><input name="name" value="{{ old('name') }}" required class="w-full rounded-xl glass-input px-3 py-2 text-xs"></div>
                <div><label class="mb-1 block text-[10px] font-bold text-[#2c4d41]">Email</label><input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl glass-input px-3 py-2 text-xs"></div>
                <div><label class="mb-1 block text-[10px] font-bold text-[#2c4d41]">Password · 12+ characters</label><input type="password" name="password" required minlength="12" class="w-full rounded-xl glass-input px-3 py-2 text-xs"></div>
                <div><label class="mb-1 block text-[10px] font-bold text-[#2c4d41]">Confirm password</label><input type="password" name="password_confirmation" required minlength="12" class="w-full rounded-xl glass-input px-3 py-2 text-xs"></div>
                @if ($errors->any())<div class="text-[10px] font-semibold text-rose-700">{{ $errors->first() }}</div>@endif
                <button class="w-full rounded-xl bg-gradient-to-r from-[#58967d] to-[#2c4d41] px-4 py-2.5 text-xs font-bold text-white">Create admin</button>
            </form>
            <div class="mt-5 border-t border-white/40 pt-4">
                <h3 class="text-[10px] font-bold uppercase tracking-wider text-[#427863]">Administrators</h3>
                <div class="mt-2 space-y-2">@forelse ($admins as $admin)<div class="flex justify-between gap-2 text-[10px]"><span class="font-semibold text-[#1b382b]">{{ $admin->name }}</span><span class="truncate text-[#427863]">{{ $admin->email }}</span></div>@empty<p class="text-[10px] text-[#427863]">No admins created yet.</p>@endforelse</div>
            </div>
        </section>
    </div>

    <section class="glass-card p-5">
        <div class="mb-4 flex flex-wrap items-end justify-between gap-3 border-b border-white/40 pb-3">
            <div>
                <h2 class="text-sm font-extrabold text-[#1b382b]">Demo users</h2>
                <p class="mt-1 text-[10px] text-[#427863]">Anonymous browser identities with their sessions and page visits. A user label stays the same when they return on this browser.</p>
            </div>
            <span class="text-[10px] font-semibold text-[#58967d]">{{ number_format($visitors->total()) }} users</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[11px]">
                <thead class="text-[9px] font-bold uppercase tracking-wider text-[#427863]"><tr><th class="py-2">Demo user</th><th>First seen</th><th>Last active</th><th>Sessions</th><th>Page visits</th><th>Status</th><th></th></tr></thead>
                <tbody>
                @forelse ($visitors as $demoVisitor)
                    <tr class="border-t border-white/30 text-[#1b382b]">
                        <td class="py-2.5 font-bold">Demo user {{ $demoVisitor->id }}</td>
                        <td>{{ $demoVisitor->sessions_min_started_at ? \Illuminate\Support\Carbon::parse($demoVisitor->sessions_min_started_at)->format('M j, H:i') : '—' }}</td>
                        <td>{{ $demoVisitor->sessions_max_last_seen_at ? \Illuminate\Support\Carbon::parse($demoVisitor->sessions_max_last_seen_at)->diffForHumans() : '—' }}</td>
                        <td>{{ $demoVisitor->sessions_count }}</td>
                        <td>{{ $demoVisitor->page_views_count }}</td>
                        <td><span class="rounded-full px-2 py-1 text-[9px] font-bold {{ $demoVisitor->active_sessions_count > 0 ? 'bg-emerald-500/15 text-emerald-800' : 'bg-slate-500/10 text-slate-600' }}">{{ $demoVisitor->active_sessions_count > 0 ? 'Active' : 'Inactive' }}</span></td>
                        <td class="text-right"><a href="{{ route('admin.demo-users.show', $demoVisitor) }}" class="font-bold text-[#366050] hover:underline">View activity</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-8 text-center text-[#427863]">Demo users will appear here when someone opens /demo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $visitors->links() }}</div>
    </section>

    <section class="glass-card p-5">
        <div class="mb-4 flex flex-wrap items-end justify-between gap-3 border-b border-white/40 pb-3">
            <div>
                <h2 class="text-sm font-extrabold text-[#1b382b]">Module access</h2>
                <p class="mt-1 text-[10px] text-[#427863]">Control which sections administrators and demo visitors can open. Disabled sections are hidden and blocked by the server.</p>
            </div>
            <span class="text-[10px] font-semibold text-[#427863]">Super admin access is always retained</span>
        </div>
        <form action="{{ route('admin.modules.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px]">
                    <thead class="text-[9px] font-bold uppercase tracking-wider text-[#427863]"><tr><th class="py-2">Workspace section</th><th class="py-2 text-center">Admins</th><th class="py-2 text-center">Demo visitors</th></tr></thead>
                    <tbody>
                    @foreach (\App\Models\ModuleSetting::MODULES as $moduleSlug => $moduleLabel)
                        @php($moduleSetting = $modules->get($moduleSlug))
                        <tr class="border-t border-white/30">
                            <td class="py-2.5 font-semibold text-[#1b382b]">{{ $moduleLabel }}</td>
                            <td class="py-2.5 text-center">
                                <label class="inline-flex cursor-pointer items-center gap-2 text-[10px] font-semibold text-[#427863]">
                                    <input type="hidden" name="modules[{{ $moduleSlug }}][admin]" value="0">
                                    <input type="checkbox" name="modules[{{ $moduleSlug }}][admin]" value="1" @checked($moduleSetting?->admin_enabled ?? true) class="h-4 w-4 rounded border-emerald-300 text-[#58967d] focus:ring-[#58967d]">
                                    <span>Enabled</span>
                                </label>
                            </td>
                            <td class="py-2.5 text-center">
                                <label class="inline-flex cursor-pointer items-center gap-2 text-[10px] font-semibold text-[#427863]">
                                    <input type="hidden" name="modules[{{ $moduleSlug }}][demo]" value="0">
                                    <input type="checkbox" name="modules[{{ $moduleSlug }}][demo]" value="1" @checked($moduleSetting?->demo_enabled ?? true) class="h-4 w-4 rounded border-emerald-300 text-[#58967d] focus:ring-[#58967d]">
                                    <span>Enabled</span>
                                </label>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($errors->any())
                <p class="mt-3 text-[10px] font-semibold text-rose-700">{{ $errors->first() }}</p>
            @endif
            <div class="mt-4 flex justify-end">
                <button class="rounded-xl bg-gradient-to-r from-[#58967d] to-[#2c4d41] px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-[#366050]/20 hover:brightness-110">Save module access</button>
            </div>
        </form>
    </section>

    <section class="glass-card p-5">
        <div class="mb-3"><h2 class="text-sm font-extrabold text-[#1b382b]">Recent demo activity</h2><p class="mt-1 text-[10px] text-[#427863]">Page visits, session starts/ends, and clicked controls. Input values are never recorded.</p></div>
        <div class="overflow-x-auto"><table class="w-full text-left text-[11px]"><thead class="text-[9px] font-bold uppercase tracking-wider text-[#427863]"><tr><th class="py-2">Time</th><th>Visitor</th><th>Event</th><th>Page</th><th>Clicked control</th><th>Browser</th></tr></thead><tbody>@forelse ($activities as $activity)<tr class="border-t border-white/30"><td class="py-2.5 text-[#427863]">{{ $activity->created_at->format('M j, H:i:s') }}</td><td class="font-semibold text-[#1b382b]">@if ($activity->demoSession->visitor)<a href="{{ route('admin.demo-users.show', $activity->demoSession->visitor) }}" class="hover:underline">Demo user {{ $activity->demoSession->visitor->id }}</a>@else<span>Demo user {{ $activity->demoSession->id }}</span>@endif</td><td class="capitalize text-[#1b382b]">{{ $activity->event }}</td><td class="text-[#1b382b]">{{ $activity->page ?? '—' }}</td><td class="text-[#1b382b]">{{ $activity->action ?? '—' }}</td><td class="text-[#427863]">{{ $activity->demoSession->browser }} · {{ $activity->demoSession->platform }}</td></tr>@empty<tr><td colspan="6" class="py-6 text-center text-[#427863]">Activity will appear when visitors use the demo.</td></tr>@endforelse</tbody></table></div>
        <div class="mt-4">{{ $activities->links() }}</div>
    </section>
</div>
@endsection

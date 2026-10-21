<section class="glass-card p-5">
    <div class="mb-4 flex flex-wrap items-start justify-between gap-3 border-b border-emerald-900/10 pb-3">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-800">Private demo workspace</p>
            <h2 class="mt-1 text-base font-extrabold text-[#1b382b]">{{ \Illuminate\Support\Str::headline($demoModule) }} records</h2>
            <p class="mt-1 text-xs text-[#365b4c]">Only this browser's demo user can access these records. Changes stay in this demo workspace.</p>
        </div>
        <span class="rounded-full bg-emerald-900/10 px-3 py-1 text-[10px] font-bold text-emerald-900">{{ $demoRecords->count() }} records</span>
    </div>

    @if (session('demo_record_status'))
        <p class="mb-3 rounded-lg bg-emerald-100 px-3 py-2 text-xs font-semibold text-emerald-900">{{ session('demo_record_status') }}</p>
    @endif

    <form action="{{ route('demo.records.store', ['module' => $demoModule]) }}" method="POST" class="mb-5 grid gap-2 md:grid-cols-[1fr_2fr_auto]">
        @csrf
        <input name="title" required maxlength="160" placeholder="Record name" class="rounded-xl glass-input px-3 py-2 text-xs text-[#1b382b]">
        <input name="description" maxlength="1000" placeholder="Short note (optional)" class="rounded-xl glass-input px-3 py-2 text-xs text-[#1b382b]">
        <button type="submit" class="rounded-xl bg-emerald-800 px-4 py-2 text-xs font-bold text-white hover:bg-emerald-900">Add record</button>
    </form>

    @if ($errors->any())
        <p class="mb-3 text-xs font-semibold text-rose-700">{{ $errors->first() }}</p>
    @endif

    <div class="grid gap-2 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($demoRecords as $demoRecord)
            <article class="rounded-xl border border-emerald-900/10 bg-white/80 p-3 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="break-words text-xs font-bold text-[#1b382b]">{{ $demoRecord->title }}</h3>
                        @if ($demoRecord->description)
                            <p class="mt-1 text-[11px] leading-relaxed text-[#365b4c]">{{ $demoRecord->description }}</p>
                        @endif
                    </div>
                    <form action="{{ route('demo.records.destroy', ['module' => $demoModule, 'record' => $demoRecord]) }}" method="POST" onsubmit="return confirm('Delete this private demo record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="shrink-0 rounded-lg px-2 py-1 text-[10px] font-bold text-rose-700 hover:bg-rose-50">Delete</button>
                    </form>
                </div>
            </article>
        @empty
            <p class="text-xs text-[#365b4c]">No records here. Add a new one above.</p>
        @endforelse
    </div>
</section>

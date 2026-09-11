@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center p-4">
    <div class="w-full max-w-md glass-panel p-8 rounded-3xl shadow-2xl border border-white/90 animate-fade-in relative overflow-hidden">
        
        <!-- Subtle Top Glass Shine Effect -->
        <div class="absolute -top-12 -left-12 w-40 h-40 bg-emerald-300/30 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Logo & Branding Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#58967d] to-[#2c4d41] mx-auto flex items-center justify-center text-white shadow-lg shadow-[#366050]/25 border border-white/50 mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#1b382b]">Nexora CRM</h1>
            <p class="text-xs text-[#427863] mt-1 font-medium">Welcome back! Sign in to access your sales workspace.</p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('dashboard') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-[#2c4d41] mb-1.5">Work Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#427863]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <input type="email" value="olivia.carter@nexoracrm.com" required class="w-full pl-10 pr-4 py-3 text-xs font-semibold rounded-xl glass-input text-[#1b382b] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#2c4d41] mb-1.5">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#427863]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input type="password" value="••••••••••••" required class="w-full pl-10 pr-4 py-3 text-xs font-semibold rounded-xl glass-input text-[#1b382b] focus:outline-none">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 text-[#2c4d41] cursor-pointer">
                    <input type="checkbox" checked class="w-4 h-4 rounded text-[#58967d] focus:ring-[#58967d] border-emerald-300">
                    <span class="font-medium">Remember 30 days</span>
                </label>
                <a href="#" class="text-[#58967d] font-bold hover:underline">Forgot password?</a>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-[#58967d] to-[#2c4d41] text-white text-xs font-extrabold shadow-lg shadow-[#366050]/25 hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <span>Sign In to Workspace</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>

        <!-- Divider -->
        <div class="my-6 flex items-center gap-3">
            <div class="flex-1 h-px bg-white/60"></div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#427863]">Or Demo Quick Sign-In</span>
            <div class="flex-1 h-px bg-white/60"></div>
        </div>

        <!-- Demo Sign-In Action -->
        <a href="{{ route('dashboard') }}" class="w-full py-3 px-4 rounded-xl glass-card flex items-center justify-center gap-3 text-xs font-bold text-[#1b382b] hover:bg-white/90 transition-all border border-white/80">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Launch Live Demo Workspace (Olivia Carter)</span>
        </a>

        <!-- Footer terms -->
        <p class="text-[11px] text-center text-[#427863] mt-6">
            Protected by Nexora Enterprise Security &bull; 2026 Edition
        </p>

    </div>
</div>
@endsection

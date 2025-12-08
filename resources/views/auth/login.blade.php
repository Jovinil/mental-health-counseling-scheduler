{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.default')

@section('content')
@php
    // Controller can pass $role = 'user' or 'counselor'
    $activeRole = $role ?? 'user';
@endphp

<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="w-full max-w-4xl">
        {{-- Outer card with subtle gradient to match the rest of the app --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0 card bg-gradient-to-br from-white via-[#f8f5ff] to-[#f3faff] shadow-2xl rounded-3xl border border-base-200 overflow-hidden">

            {{-- Left side: friendly intro --}}
            <div class="hidden md:flex flex-col justify-between p-8 bg-gradient-to-br from-[#ede9ff] via-[#e0f2fe] to-[#fdf2ff]">
                <div class="space-y-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-primary/80">
                        MindCare
                    </p>
                    <h2 class="text-xl font-semibold text-slate-800">
                        Welcome back 👋
                    </h2>
                    <p class="text-sm text-slate-600">
                        Sign in as a client or counselor to manage your sessions, track progress, and stay on top of your mental wellness.
                    </p>
                </div>

                <div class="mt-6 space-y-3 text-xs text-slate-700">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white/70 shadow-sm">
                            💬
                        </span>
                        <p>Book and manage counseling sessions with licensed professionals.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white/70 shadow-sm">
                            📊
                        </span>
                        <p>Counselors can monitor schedules and support clients efficiently.</p>
                    </div>
                </div>
            </div>

            {{-- Right side: forms --}}
            <div class="p-6 md:p-8 bg-base-100/90 backdrop-blur">
                <div class="flex flex-col items-center space-y-2 mb-4">
                    <div class="avatar placeholder">
                        <div class="bg-primary/10 text-primary rounded-full w-12">
                            <span class="text-lg font-bold">M</span>
                        </div>
                    </div>
                    <div class="text-center space-y-1">
                        <h1 class="text-xl font-semibold text-gray-800">
                            Sign in to MindCare
                        </h1>
                        <p class="text-xs text-gray-500">
                            Choose your role to continue to your dashboard.
                        </p>
                    </div>
                </div>

                {{-- Role toggle --}}
                <div class="bg-base-200/70 rounded-full p-1 flex gap-1 mb-5">
                    <button
                        type="button"
                        class="flex-1 btn btn-sm rounded-full border-none transition
                            {{ $activeRole === 'user' ? 'btn-primary shadow' : 'btn-ghost text-gray-600' }}"
                        data-role-toggle="user"
                    >
                        👤 Client
                    </button>
                    <button
                        type="button"
                        class="flex-1 btn btn-sm rounded-full border-none transition
                            {{ $activeRole === 'counselor' ? 'btn-primary shadow' : 'btn-ghost text-gray-600' }}"
                        data-role-toggle="counselor"
                    >
                        🧑‍⚕️ Counselor
                    </button>
                </div>

                {{-- Error message (shared) --}}
                @if ($errors->any())
                    <div class="alert alert-error text-sm py-2 mb-3">
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- CLIENT LOGIN FORM --}}
                <div id="userFormWrap" class="{{ $activeRole === 'user' ? '' : 'hidden' }}">
                    <form method="POST" action="{{ route('user.login.authenticate') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="role" value="user">

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">Email</span>
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="input input-bordered w-full rounded-xl"
                                placeholder="you@example.com"
                                required
                                autofocus
                                value="{{ old('email') }}"
                            >
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">Password</span>
                            </label>
                            <input
                                type="password"
                                name="password"
                                class="input input-bordered w-full rounded-xl"
                                placeholder="••••••••"
                                required
                            >
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="checkbox checkbox-xs">
                                <span>Remember me</span>
                            </label>
                            <a class="link link-hover">Forgot password?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-full rounded-full mt-2">
                            Continue as Client
                        </button>
                    </form>
                </div>

                {{-- COUNSELOR LOGIN FORM --}}
                <div id="counselorFormWrap" class="{{ $activeRole === 'counselor' ? '' : 'hidden' }}">
                    <form method="POST" action="{{ route('counselor.login.authenticate') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="role" value="counselor">

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">Counselor Email</span>
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="input input-bordered w-full rounded-xl"
                                placeholder="you@practice.com"
                                required
                                value="{{ old('email') }}"
                            >
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">Password</span>
                            </label>
                            <input
                                type="password"
                                name="password"
                                class="input input-bordered w-full rounded-xl"
                                placeholder="••••••••"
                                required
                            >
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="checkbox checkbox-xs">
                                <span>Remember me</span>
                            </label>
                            <a class="link link-hover" href="{{ route('counselor.register') }}">Need access?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-full rounded-full mt-2">
                            Continue as Counselor
                        </button>
                    </form>
                </div>

                {{-- Guest / info footer --}}
                <div class="mt-6 space-y-2 text-center">
                    <div class="text-[11px] text-gray-400">
                        Prefer not to sign in yet?
                        <a href="{{ route('home') }}" class="link link-primary text-[11px]">
                            Continue as guest
                        </a>
                    </div>
                    <div id="userRegBtn" class="text-[11px] text-gray-400 {{ $activeRole === 'user' ? '' : 'hidden' }}">
                        Don't have an account?
                        <a href="{{ route('user.register') }}" class="link link-primary text-[11px]">
                            Register
                        </a>
                    </div>

                    <p class="text-[10px] text-gray-400 max-w-xs mx-auto">
                        You can browse counselors and explore the platform as a guest.
                        Booking or managing sessions will require an account later.
                    </p>
                    <p class="text-[10px] text-gray-400">
                        By signing in, you agree to follow your organization’s privacy and confidentiality guidelines.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const userWrap = document.getElementById('userFormWrap');
    const userRegBtn = document.getElementById('userRegBtn');
    const counselorWrap = document.getElementById('counselorFormWrap');
    const buttons = document.querySelectorAll('[data-role-toggle]');

    function setActive(role) {
        if (role === 'user') {
            userRegBtn.classList.remove('hidden');
            userWrap.classList.remove('hidden');
            counselorWrap.classList.add('hidden');
        } else {
            userRegBtn.classList.add('hidden');
            counselorWrap.classList.remove('hidden');
            userWrap.classList.add('hidden');
        }

        buttons.forEach(btn => {
            const btnRole = btn.getAttribute('data-role-toggle');
            if (btnRole === role) {
                btn.classList.remove('btn-ghost', 'text-gray-600');
                btn.classList.add('btn-primary', 'shadow');
            } else {
                btn.classList.add('btn-ghost', 'text-gray-600');
                btn.classList.remove('btn-primary', 'shadow');
            }
        });
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const role = btn.getAttribute('data-role-toggle');
            setActive(role);
        });
    });
});
</script>
@endpush

@extends('layouts.app')

@section('content')
@php
    $activeRole = $role ?? 'user';
@endphp

<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="w-full max-w-4xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0 card bg-gradient-to-br from-white via-[#f8f5ff] to-[#f3faff] shadow-2xl rounded-3xl border border-base-200 overflow-hidden">

            {{-- Left panel --}}
            <div class="hidden md:flex flex-col justify-between p-8 bg-gradient-to-br from-[#ede9ff] via-[#e0f2fe] to-[#fdf2ff]">
                <div class="space-y-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-primary/80">
                        MindCare
                    </p>
                    <h2 class="text-xl font-semibold text-slate-800">
                        Create your MindCare account 🌱
                    </h2>
                    <p class="text-sm text-slate-600">
                        Whether you’re seeking support or providing it, you’re in the right place.
                        Sign up as a client or counselor to get started.
                    </p>
                </div>

                <div class="mt-6 space-y-3 text-xs text-slate-700">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white/70 shadow-sm">
                            👤
                        </span>
                        <p>Clients can easily book and manage mental health sessions.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white/70 shadow-sm">
                            🧑‍⚕️
                        </span>
                        <p>Counselors get a clear view of their schedule and client sessions.</p>
                    </div>
                </div>
            </div>

            {{-- Right panel: forms --}}
            <div class="p-6 md:p-8 bg-base-100/90 backdrop-blur">
                <div class="flex flex-col items-center space-y-2 mb-4">
                    <div class="avatar placeholder">
                        <div class="bg-primary/10 text-primary rounded-full w-12">
                            <span class="text-lg font-bold">M</span>
                        </div>
                    </div>
                    <div class="text-center space-y-1">
                        <h1 class="text-xl font-semibold text-gray-800">
                            Sign up to MindCare
                        </h1>
                        <p class="text-xs text-gray-500">
                            Choose your role to create the right type of account.
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

                {{-- Error message --}}
                @if ($errors->any())
                    <div class="alert alert-error text-sm py-2 mb-3">
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- CLIENT REGISTRATION FORM --}}
                <div id="userFormWrap" class="{{ $activeRole === 'user' ? '' : 'hidden' }}">
                    <form method="POST" action="{{ route('user.register.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="role" value="user">

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">Full Name</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                class="input input-bordered w-full rounded-xl"
                                placeholder="Alex Santos"
                                required
                                value="{{ old('name') }}"
                            >
                        </div>

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
                                value="{{ old('email') }}"
                            >
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">Phone (optional)</span>
                            </label>
                            <input
                                type="text"
                                name="phone"
                                class="input input-bordered w-full rounded-xl"
                                placeholder="+63 900 000 0000"
                                value="{{ old('phone') }}"
                            >
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
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
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">Confirm Password</span>
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="input input-bordered w-full rounded-xl"
                                    placeholder="••••••••"
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-full rounded-full mt-2">
                            Create Client Account
                        </button>
                    </form>
                </div>

                {{-- COUNSELOR REGISTRATION FORM --}}
                <div id="counselorFormWrap" class="{{ $activeRole === 'counselor' ? '' : 'hidden' }}">
                    <form method="POST" action="{{ route('counselor.register.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="role" value="counselor">

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">Full Name</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                class="input input-bordered w-full rounded-xl"
                                placeholder="Dr. Sarah Cruz"
                                required
                                value="{{ old('name') }}"
                            >
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">Professional Email</span>
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
                                <span class="label-text text-xs font-medium text-gray-600">Occupation / Title</span>
                            </label>
                            <input
                                type="text"
                                name="occupation"
                                class="input input-bordered w-full rounded-xl"
                                placeholder="Licensed Psychologist"
                                value="{{ old('occupation') }}"
                            >
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">
                                    Specialties (comma-separated)
                                </span>
                            </label>
                            <input
                                type="text"
                                name="specialties"
                                class="input input-bordered w-full rounded-xl"
                                placeholder="Anxiety, Depression, Trauma"
                                value="{{ old('specialties') }}"
                            >
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">
                                        Years of Experience
                                    </span>
                                </label>
                                <input
                                    type="number"
                                    name="years_of_experience"
                                    class="input input-bordered w-full rounded-xl"
                                    min="0"
                                    max="80"
                                    placeholder="5"
                                    value="{{ old('years_of_experience') }}"
                                >
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">
                                        Languages
                                    </span>
                                </label>
                                <input
                                    type="text"
                                    name="languages"
                                    class="input input-bordered w-full rounded-xl"
                                    placeholder="English, Filipino"
                                    value="{{ old('languages') }}"
                                >
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">
                                    Short Bio / Description
                                </span>
                            </label>
                            <textarea
                                name="description"
                                class="textarea textarea-bordered w-full rounded-xl min-h-[80px]"
                                placeholder="Share a short, friendly description of your approach."
                            >{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
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
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">Confirm Password</span>
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="input input-bordered w-full rounded-xl"
                                    placeholder="••••••••"
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-full rounded-full mt-2">
                            Create Counselor Account
                        </button>
                    </form>
                </div>

                {{-- Footer: switch to login --}}
                <div class="mt-6 space-y-1 text-center">
                    <p class="text-[11px] text-gray-400">
                        Already have an account?
                        <a href="{{ route('user.login') }}" class="link link-primary text-[11px]">
                            Sign in
                        </a>
                    </p>
                    <p class="text-[10px] text-gray-400 max-w-xs mx-auto">
                        By creating an account, you agree to protect the privacy and confidentiality of all
                        information shared within MindCare.
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
    const counselorWrap = document.getElementById('counselorFormWrap');
    const buttons = document.querySelectorAll('[data-role-toggle]');

    function setActive(role) {
        if (role === 'user') {
            userWrap.classList.remove('hidden');
            counselorWrap.classList.add('hidden');
        } else {
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

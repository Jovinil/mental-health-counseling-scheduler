{{-- resources/views/user/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                    Welcome back, {{ $user->name }}!
                </h1>
                <p class="text-sm text-gray-500">
                    Member since {{ $user->created_at->format('F Y') }}
                </p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline btn-sm rounded-full">
                Back to Home
            </a>
        </div>

        {{-- Stats row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-card label="Total Sessions" :value="$totalSessions" />
            <x-stat-card label="Upcoming" :value="$upcomingAppointments->count()" />
            <x-stat-card label="This Month" :value="$thisMonthSessions" />
            <x-stat-card label="Streak" :value="$streakWeeks . ' weeks'" />
        </div>

        {{-- Main layout: upcoming + past + sidebar --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            {{-- Sessions column --}}
            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-base font-semibold text-gray-800 px-1">Upcoming Sessions</h2>

                @forelse ($upcomingAppointments as $appointment)
                    @php
                        $sessionDate = \Carbon\Carbon::parse($appointment->session_date);
                        $sessionTime = $appointment->session_time
                            ? \Carbon\Carbon::parse($appointment->session_time)->format('h:i A')
                            : null;
                    @endphp
                    <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                        <div class="card-body space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-12 rounded-full ring ring-primary/20 ring-offset-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->counselor->name) }}&background=random" alt="counselor" />
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $appointment->counselor->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $appointment->counselor->occupation ?? 'Licensed Counselor' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="badge badge-success badge-outline capitalize">
                                    {{ $appointment->status }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10">
                                        D
                                    </span>
                                    <span>{{ $sessionDate->format('M d, Y') }}</span>
                                </div>
                                @if($sessionTime)
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10">
                                            T
                                        </span>
                                        <span>{{ $sessionTime }}</span>
                                    </div>
                                @endif
                                <div class="badge badge-outline rounded-full">
                                    {{ $appointment->appointmentSession->title ?? 'Counseling Session' }}
                                </div>
                                <div class="badge badge-outline rounded-full">
                                    {{ $appointment->appointmentSession->duration ?? 60 }} min
                                </div>
                            </div>

                            @if($appointment->notes)
                                <div class="mt-2">
                                    <p class="text-xs uppercase text-gray-400 mb-1 tracking-wide">Session Focus</p>
                                    <p class="text-sm text-gray-700">{{ $appointment->notes }}</p>
                                </div>
                            @endif

                            <div class="flex flex-wrap justify-between items-center gap-3 mt-2">
                                <button class="btn btn-primary btn-sm rounded-full">
                                    Join Session
                                </button>
                                <div class="flex gap-2">
                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-ghost btn-xs rounded-full">
                                        View Details
                                    </a>
                                    <form method="POST" action="{{ route('appointments.destroy', $appointment) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline btn-xs rounded-full">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card bg-base-100 shadow-md rounded-2xl">
                        <div class="card-body items-center text-center">
                            <h2 class="card-title text-lg">No upcoming sessions yet</h2>
                            <p class="text-sm text-gray-500">
                                Book your first counseling session to see it here.
                            </p>
                            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm rounded-full mt-2" data-requires-login>
                                Book a Session
                            </a>
                        </div>
                    </div>
                @endforelse

                <h2 class="text-base font-semibold text-gray-800 px-1 mt-6">Recent Past Sessions</h2>
                @forelse ($pastAppointments as $appointment)
                    @php
                        $sessionDate = \Carbon\Carbon::parse($appointment->session_date);
                        $sessionTime = $appointment->session_time
                            ? \Carbon\Carbon::parse($appointment->session_time)->format('h:i A')
                            : null;
                    @endphp
                    <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                        <div class="card-body space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-12 rounded-full ring ring-primary/20 ring-offset-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->counselor->name) }}&background=random" alt="counselor" />
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $appointment->counselor->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $appointment->counselor->occupation ?? 'Licensed Counselor' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="badge badge-outline capitalize">
                                    {{ $appointment->status }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10">
                                        D
                                    </span>
                                    <span>{{ $sessionDate->format('M d, Y') }}</span>
                                </div>
                                @if($sessionTime)
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10">
                                            T
                                        </span>
                                        <span>{{ $sessionTime }}</span>
                                    </div>
                                @endif
                                <div class="badge badge-outline rounded-full">
                                    {{ $appointment->appointmentSession->title ?? 'Counseling Session' }}
                                </div>
                            </div>

                            <div class="flex justify-between items-center text-[11px] text-gray-500">
                                <span>Completed on {{ $sessionDate->format('M d, Y') }}</span>
                                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-ghost btn-xs rounded-full">
                                    View details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 px-1">No past sessions yet.</p>
                @endforelse
            </div>

            {{-- Sidebar: progress --}}
            <aside class="space-y-4">
                <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                    <div class="card-body">
                        <h2 class="card-title text-base mb-1">Your Progress</h2>
                        <p class="text-xs text-gray-500 mb-4">
                            Track your wellness journey
                        </p>

                        @foreach($progressData as $label => $value)
                            <div class="mb-3">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-600">{{ $label }}</span>
                                    <span class="font-semibold">{{ $value }}%</span>
                                </div>
                                <progress class="progress progress-primary w-full" value="{{ $value }}" max="100"></progress>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection

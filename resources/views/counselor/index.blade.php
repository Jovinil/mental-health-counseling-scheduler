{{-- resources/views/counselor/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase text-gray-500 tracking-wide">Counselor Portal</p>
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                    Welcome back, {{ $counselor->name }}!
                </h1>
                <p class="text-sm text-gray-500">
                    Here's your schedule for today, {{ now()->format('l, F j, Y') }}
                </p>
            </div>
        </div>

        {{-- Stats row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-card label="Today's Sessions" :value="$todaySessions" />
            <x-stat-card label="This Week" :value="$weekSessions" />
            <x-stat-card label="Total Sessions" :value="$totalSessions" />
            <x-stat-card label="Rating" :value="number_format($counselor->rating ?? 4.9, 1)" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            {{-- Today's appointments --}}
            <section class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-gray-800">
                        Today’s Appointments
                    </h2>
                    <a href="{{ route('counselor.appointments.index') }}" class="btn btn-ghost btn-xs rounded-full">
                        View all
                    </a>
                </div>

                @forelse($todayAppointments as $appointment)
                    <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                        <div class="card-body space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary/10 text-primary rounded-full w-10">
                                            <span class="text-sm">{{ strtoupper(substr($appointment->user->name, 0, 2)) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $appointment->user->name }}</p>
                                        <p class="text-xs text-gray-500">Client</p>
                                    </div>
                                </div>
                                <span class="badge badge-success badge-outline capitalize">
                                    {{ $appointment->status }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10">
                                        ⏰
                                    </span>
                                    <span>{{ \Carbon\Carbon::parse($appointment->session_time)->format('h:i A') }}</span>
                                </div>
                                <div class="badge badge-outline rounded-full">
                                    {{ $appointment->appointmentSession->title ?? 'Counseling Session' }}
                                </div>
                                <div class="badge badge-outline rounded-full">
                                    {{ $appointment->appointmentSession->duration ?? 60 }} min
                                </div>
                            </div>

                            @if($appointment->notes)
                                <div class="mt-2">
                                    <p class="text-xs uppercase text-gray-400 mb-1 tracking-wide">Session Notes (client)</p>
                                    <p class="text-sm text-gray-700">{{ $appointment->notes }}</p>
                                </div>
                            @endif

                            <div class="flex flex-wrap justify-between items-center gap-3 mt-2">
                                <div class="join">
                                    <form method="POST" action="{{ route('counselor.appointments.update', $appointment) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button class="btn btn-xs join-item {{ $appointment->status === 'confirmed' ? 'btn-primary' : 'btn-ghost' }}">
                                            Confirm
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('counselor.appointments.update', $appointment) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button class="btn btn-xs join-item {{ $appointment->status === 'completed' ? 'btn-primary' : 'btn-ghost' }}">
                                            Complete
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('counselor.appointments.update', $appointment) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button class="btn btn-xs join-item btn-ghost">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card bg-base-100 shadow-md rounded-2xl">
                        <div class="card-body text-center">
                            <h2 class="card-title text-lg">No sessions scheduled for today</h2>
                            <p class="text-sm text-gray-500">
                                Once clients book with you, they’ll show up here.
                            </p>
                        </div>
                    </div>
                @endforelse
            </section>

            {{-- Week overview --}}
            <aside class="space-y-4">
                <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                    <div class="card-body">
                        <h2 class="card-title text-base mb-1">Week Overview</h2>
                        <p class="text-xs text-gray-500 mb-3">
                            Your schedule for the upcoming week
                        </p>

                        {{-- For now this is static; later you can pass real data grouped by weekday. --}}
                        @php
                            $week = [
                                'Monday' => '4 sessions',
                                'Tuesday' => '3 sessions',
                                'Wednesday' => '5 sessions',
                                'Thursday' => '2 sessions',
                                'Friday' => '3 sessions',
                            ];
                        @endphp

                        <div class="space-y-2">
                            @foreach($week as $day => $label)
                                <div class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-base-200/60 transition">
                                    <div>
                                        <p class="text-xs font-medium text-gray-700">{{ $day }}</p>
                                    </div>
                                    <span class="badge badge-outline rounded-full text-xs px-3">
                                        {{ $label }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection

{{-- resources/views/user/appointments/index.blade.php --}}
@extends('layouts.app')

@section('content')
    @php
        $view = $view ?? request('view', 'upcoming');
    @endphp
    <div class="flex flex-col gap-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    My Sessions
                </h1>
                <p class="text-sm text-gray-500">
                    View your upcoming and past counseling appointments.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm rounded-full" data-requires-login>
                    Book New Session
                </a>
                <a href="{{ route('user.dashboard') }}" class="btn btn-ghost btn-sm rounded-full">
                    Back to Dashboard
                </a>
            </div>
        </div>

        {{-- Filter tabs --}}
        <div class="tabs tabs-boxed bg-base-100/80 border border-base-200 rounded-2xl shadow-sm mb-2">
            <a href="{{ route('appointments.index', ['view' => 'upcoming']) }}"
               class="tab flex-1 {{ $view === 'upcoming' ? 'tab-active' : '' }}">
                Upcoming
            </a>
            <a href="{{ route('appointments.index', ['view' => 'past']) }}"
               class="tab flex-1 {{ $view === 'past' ? 'tab-active' : '' }}">
                Past
            </a>
            <a href="{{ route('appointments.index', ['view' => 'all']) }}"
               class="tab flex-1 {{ $view === 'all' ? 'tab-active' : '' }}">
                All
            </a>
        </div>

        {{-- List --}}
        @if ($appointments->count() === 0)
            <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                <div class="card-body text-center">
                    <h2 class="card-title text-lg mb-1">
                        No sessions {{ $view === 'upcoming' ? 'scheduled' : '' }} yet
                    </h2>
                    <p class="text-sm text-gray-500 mb-3">
                        Once you book a counseling session, it will appear here.
                    </p>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm rounded-full" data-requires-login>
                        Book a Session
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($appointments as $appointment)
                    @php
                        $sessionDate = \Carbon\Carbon::parse($appointment->session_date);
                        $sessionTime = $appointment->session_time
                            ? \Carbon\Carbon::parse($appointment->session_time)->format('h:i A')
                            : null;
                        $isUpcoming = $sessionDate->isFuture() || $sessionDate->isToday();
                        $statusColor = match($appointment->status) {
                            'completed' => 'badge-success',
                            'cancelled' => 'badge-error',
                            'confirmed' => 'badge-primary',
                            default => 'badge-ghost',
                        };
                    @endphp

                    <div class="card bg-base-100 shadow-sm rounded-2xl border border-base-200">
                        <div class="card-body space-y-3">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-10 rounded-full ring ring-primary/10 ring-offset-2">
                                            <img
                                                src="https://ui-avatars.com/api/?name={{ urlencode(optional($appointment->counselor)->name ?? 'Counselor') }}&background=random"
                                                alt="Counselor"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ optional($appointment->counselor)->name ?? 'Counselor' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ optional($appointment->counselor)->occupation ?? 'Counseling Session' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col items-end gap-1 text-right">
                                    <span class="badge badge-outline {{ $statusColor }} capitalize">
                                        {{ $appointment->status }}
                                    </span>
                                    <span class="text-[11px] text-gray-400">
                                        {{ $isUpcoming ? 'Upcoming' : 'Past' }}
                                    </span>
                                </div>
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
                                    {{ optional($appointment->appointmentSession)->title ?? 'Counseling' }}
                                </div>

                                @if(optional($appointment->appointmentSession)->duration)
                                    <div class="badge badge-outline rounded-full">
                                        {{ $appointment->appointmentSession->duration }} min
                                    </div>
                                @endif
                            </div>

                            @if($appointment->notes)
                                <div>
                                    <p class="text-xs uppercase text-gray-400 mb-1 tracking-wide">Session Focus</p>
                                    <p class="text-sm text-gray-700">
                                        {{ \Illuminate\Support\Str::limit($appointment->notes, 140) }}
                                    </p>
                                </div>
                            @endif

                            <div class="flex flex-wrap justify-between items-center gap-3 pt-2 border-t border-base-200/80">
                                <span class="text-[11px] text-gray-400">
                                    Booked on {{ $appointment->created_at->format('M d, Y · h:i A') }}
                                </span>

                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('appointments.show', $appointment) }}"
                                       class="btn btn-ghost btn-xs rounded-full">
                                        View details
                                    </a>

                                    @if($isUpcoming && $appointment->status !== 'cancelled')
                                        <a href="{{ route('appointments.show', $appointment) }}#reschedule"
                                           class="btn btn-outline btn-xs rounded-full">
                                            Reschedule
                                        </a>

                                        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-outline btn-xs rounded-full"
                                                onclick="return confirm('Cancel this appointment?');">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $appointments->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection

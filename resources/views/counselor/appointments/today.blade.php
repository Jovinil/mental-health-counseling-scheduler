@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <p class="text-xs uppercase text-gray-500 tracking-wide">Counselor Portal</p>
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                    Today&#39;s Appointments
                </h1>
                <p class="text-sm text-gray-500">
                    Sessions scheduled for {{ now()->format('l, F d, Y') }}.
                </p>
            </div>

            <a href="{{ route('counselor.appointments.index') }}" class="btn btn-ghost btn-sm rounded-full">
                Back to All
            </a>
        </div>

        @if ($appointments->count() === 0)
            <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                <div class="card-body text-center">
                    <h2 class="card-title text-lg mb-1">No sessions scheduled today</h2>
                    <p class="text-sm text-gray-500">
                        Check back later for new bookings.
                    </p>
                </div>
            </div>
        @else
            <div class="space-y-3">
                @foreach($appointments as $appointment)
                    @php
                        $time = $appointment->session_time
                            ? \Carbon\Carbon::parse($appointment->session_time)->format('h:i A')
                            : null;
                        $statusColor = match($appointment->status) {
                            'completed' => 'badge-success',
                            'confirmed' => 'badge-primary',
                            'cancelled' => 'badge-error',
                            default => 'badge-ghost',
                        };
                    @endphp

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
                                <span class="badge badge-outline {{ $statusColor }} capitalize">
                                    {{ $appointment->status }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                                @if($time)
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10">
                                            🕒
                                        </span>
                                        <span>{{ $time }}</span>
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
                                <div>
                                    <p class="text-xs uppercase text-gray-400 mb-1 tracking-wide">Client Notes</p>
                                    <p class="text-sm text-gray-700">{{ $appointment->notes }}</p>
                                </div>
                            @endif

                            <div class="flex flex-wrap justify-between items-center gap-3">
                                <span class="text-[11px] text-gray-400">
                                    Booked on {{ $appointment->created_at->format('M d, Y · h:i A') }}
                                </span>

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
                @endforeach
            </div>
        @endif
    </div>
@endsection

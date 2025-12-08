@extends('layouts.app')

@section('content')
    @php
        $sessionDate = \Carbon\Carbon::parse($appointment->session_date);
        $sessionTime = $appointment->session_time
            ? \Carbon\Carbon::parse($appointment->session_time)->format('h:i A')
            : null;
        $sessionTimeValue = $appointment->session_time
            ? \Carbon\Carbon::parse($appointment->session_time)->format('H:i')
            : null;
    @endphp

    <div class="flex flex-col gap-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <p class="text-xs uppercase text-gray-500 tracking-wide">Appointment</p>
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                    {{ $appointment->appointmentSession->title ?? 'Counseling Session' }}
                </h1>
                <p class="text-sm text-gray-500">
                    Scheduled with {{ optional($appointment->counselor)->name ?? 'Counselor' }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <span class="badge badge-outline capitalize">
                    {{ $appointment->status }}
                </span>
                <a href="{{ route('appointments.index') }}" class="btn btn-ghost btn-sm rounded-full">
                    Back to My Sessions
                </a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
            <div class="card-body space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <p class="text-xs uppercase text-gray-400 tracking-wide">When</p>
                        <div class="flex items-center gap-3 text-sm text-gray-700">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10">
                                    D
                                </span>
                                <span>{{ $sessionDate->format('l, F d, Y') }}</span>
                            </div>
                            @if($sessionTime)
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10">
                                        T
                                    </span>
                                    <span>{{ $sessionTime }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-xs uppercase text-gray-400 tracking-wide">Session</p>
                        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-700">
                            <span class="badge badge-outline rounded-full">
                                {{ $appointment->appointmentSession->title ?? 'Counseling' }}
                            </span>
                            @if(optional($appointment->appointmentSession)->duration)
                                <span class="badge badge-outline rounded-full">
                                    {{ $appointment->appointmentSession->duration }} min
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <p class="text-xs uppercase text-gray-400 tracking-wide">Counselor</p>
                        <div class="flex items-center gap-3">
                            <div class="avatar placeholder">
                                <div class="bg-primary/10 text-primary rounded-full w-12">
                                    <span class="text-sm">
                                        {{ strtoupper(substr(optional($appointment->counselor)->name ?? 'C', 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ optional($appointment->counselor)->name ?? 'Counselor' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ optional($appointment->counselor)->occupation ?? 'Licensed Counselor' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-xs uppercase text-gray-400 tracking-wide">Status</p>
                        <div class="flex items-center gap-2">
                            @php
                                $statusColor = match($appointment->status) {
                                    'completed' => 'badge-success',
                                    'confirmed' => 'badge-primary',
                                    'cancelled' => 'badge-error',
                                    default => 'badge-ghost',
                                };
                            @endphp
                            <span class="badge {{ $statusColor }} badge-outline capitalize">
                                {{ $appointment->status }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($appointment->notes)
                    <div class="space-y-1">
                        <p class="text-xs uppercase text-gray-400 tracking-wide">Notes</p>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            {{ $appointment->notes }}
                        </p>
                    </div>
                @endif

                <div class="space-y-3 pt-2 border-t border-base-200/80">
                    <div class="flex flex-wrap justify-between items-center gap-3">
                        <span class="text-xs text-gray-500">
                            Booked on {{ $appointment->created_at->format('M d, Y · h:i A') }}
                        </span>

                        @if($appointment->status !== 'cancelled' && $sessionDate->isFuture())
                            <form method="POST" action="{{ route('appointments.destroy', $appointment) }}">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-outline btn-sm rounded-full"
                                    onclick="return confirm('Cancel this appointment?');"
                                >
                                    Cancel Appointment
                                </button>
                            </form>
                        @endif
                    </div>

                    @if($appointment->status !== 'cancelled' && $sessionDate->isFuture())
                        <div class="rounded-xl border border-base-200 p-4 bg-base-100/60" id="reschedule">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">Need to reschedule?</p>
                                    <p class="text-xs text-gray-500">Pick a new date and time.</p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                                @csrf
                                @method('PUT')
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text text-xs">New date</span>
                                    </label>
                                    <input type="date" name="session_date" class="input input-bordered input-sm"
                                           value="{{ old('session_date', $sessionDate->format('Y-m-d')) }}" required>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text text-xs">New time</span>
                                    </label>
                                    <input type="time" name="session_time" class="input input-bordered input-sm"
                                           value="{{ old('session_time', $sessionTimeValue) }}" required>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text text-xs">Notes (optional)</span>
                                    </label>
                                    <input type="text" name="notes" class="input input-bordered input-sm"
                                           value="{{ old('notes', $appointment->notes) }}" placeholder="Add a note">
                                </div>
                                <div class="md:col-span-3">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-full">
                                        Confirm Reschedule
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <p class="text-xs uppercase text-gray-500 tracking-wide">Counselor Portal</p>
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                    All Appointments
                </h1>
                <p class="text-sm text-gray-500">
                    Review and manage every scheduled session with your clients.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('counselor.appointments.today') }}" class="btn btn-ghost btn-sm rounded-full">
                    Today
                </a>
                <a href="{{ route('counselor.dashboard') }}" class="btn btn-outline btn-sm rounded-full">
                    Back to Dashboard
                </a>
            </div>
        </div>

        @if ($appointments->count() === 0)
            <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                <div class="card-body text-center">
                    <h2 class="card-title text-lg mb-1">No appointments yet</h2>
                    <p class="text-sm text-gray-500">
                        When clients book with you, they will appear here.
                    </p>
                </div>
            </div>
        @else
         <div class="card bg-base-100 shadow-sm rounded-2xl border border-base-200">
                <div class="card-body pb-0">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-xs uppercase text-gray-500 tracking-wide">Search</span>
                        </label>
                        <input
                            type="text"
                            id="appointments-search"
                            placeholder="Search by client, session, date, or status"
                            class="input input-bordered input-sm"
                        />
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                <div class="card-body p-0 overflow-x-auto">
                    <table class="table table-zebra" id="appointments-table">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase tracking-wide">
                                <th data-sort="client" class="cursor-pointer">Client</th>
                                <th data-sort="session" class="cursor-pointer">Session</th>
                                <th data-sort="date" class="cursor-pointer">Date</th>
                                <th data-sort="time" class="cursor-pointer">Time</th>
                                <th data-sort="status" class="cursor-pointer">Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                @php
                                    $date = \Carbon\Carbon::parse($appointment->session_date);
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
                                <tr
                                    class="text-sm"
                                    data-client="{{ strtolower($appointment->user->name) }}"
                                    data-session="{{ strtolower($appointment->appointmentSession->title ?? 'counseling session') }}"
                                    data-date="{{ $date->format('Y-m-d') }}"
                                    data-time="{{ $appointment->session_time ?? '' }}"
                                    data-status="{{ strtolower($appointment->status) }}"
                                >
                                    <td class="whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-primary/10 text-primary rounded-full w-8">
                                                    <span class="text-xs">
                                                        {{ strtoupper(substr($appointment->user->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $appointment->user->name }}</p>
                                                <p class="text-[11px] text-gray-500">Client</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="font-medium">
                                                {{ $appointment->appointmentSession->title ?? 'Counseling Session' }}
                                            </span>
                                            <span class="text-[11px] text-gray-500">
                                                {{ $appointment->appointmentSession->duration ?? 60 }} min
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $date->format('M d, Y') }}</td>
                                    <td>{{ $time ?? '—' }}</td>
                                    <td>
                                        <span class="badge badge-outline {{ $statusColor }} capitalize">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="join join-horizontal justify-end">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-body pt-4">
                    {{ $appointments->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('appointments-search');
    const table = document.getElementById('appointments-table');
    if (!input || !table) return;

    const sortState = { column: null, direction: 'asc' };

    const applyFilter = () => {
        const query = input.value.trim().toLowerCase();
        const rows = table.querySelectorAll('tbody tr');


        rows.forEach((row) => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
        };

    const sortRows = (key) => {
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const direction = sortState.column === key && sortState.direction === 'asc' ? 'desc' : 'asc';
        sortState.column = key;
        sortState.direction = direction;

        const parseValue = (row) => {
            const value = row.dataset[key] || '';
            if (key === 'date') return value;
            if (key === 'time') return value;
            return value.toLowerCase();
        };

        rows.sort((a, b) => {
            const va = parseValue(a);
            const vb = parseValue(b);
            if (va === vb) return 0;
            return (va > vb ? 1 : -1) * (direction === 'asc' ? 1 : -1);
        });

        const tbody = table.querySelector('tbody');
        rows.forEach((row) => tbody.appendChild(row));
    };

    input.addEventListener('input', applyFilter);

    table.querySelectorAll('th[data-sort]').forEach((th) => {
        th.addEventListener('click', () => sortRows(th.dataset.sort));
    });
});
</script>
@endpush

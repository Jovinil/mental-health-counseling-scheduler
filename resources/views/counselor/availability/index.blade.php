@extends('layouts.app')

@section('content')

    @php
        $dayOrder = [
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
            'Sunday' => 7,
        ];
        $sortedAvailabilities = $availabilities->sortBy(function ($item) use ($dayOrder) {
            return $dayOrder[$item->day_of_week] ?? 99;
        });
    @endphp

    <div class="flex flex-col gap-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <p class="text-xs uppercase text-gray-500 tracking-wide">Availability</p>
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                    My Availability
                </h1>
                <p class="text-sm text-gray-500">
                    Define when clients can book sessions with you.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('counselor.availability.create') }}" class="btn btn-primary btn-sm rounded-full">
                    Add Availability
                </a>
                <a href="{{ route('counselor.dashboard') }}" class="btn btn-ghost btn-sm rounded-full">
                    Back to Dashboard
                </a>
            </div>
        </div>

        @if ($availabilities->isEmpty())
            <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                <div class="card-body text-center">
                    <h2 class="card-title text-lg mb-1">No availability set</h2>
                    <p class="text-sm text-gray-500">
                        Add your available days and time ranges so clients can schedule with you.
                    </p>
                    <a href="{{ route('counselor.availability.create') }}" class="btn btn-primary btn-sm rounded-full mt-2">
                        Add availability
                    </a>
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
                            id="availability-search"
                            placeholder="Search by day or timeslot"
                            class="input input-bordered input-sm"
                        />
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
                <div class="card-body p-0 overflow-x-auto">
                    <table class="table table-zebra" id="availability-table">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase tracking-wide">
                                <th data-sort="day" class="cursor-pointer">Day</th>
                                <th data-sort="timeslot" class="cursor-pointer">Timeslot</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sortedAvailabilities as $availability)
                                <tr
                                    class="text-sm"
                                    data-day="{{ strtolower($availability->day_of_week) }}"
                                    data-day-order="{{ $dayOrder[$availability->day_of_week] ?? 99 }}"
                                    data-timeslot="{{ strtolower($availability->timeslot) }}"
                                >
                                    <td>{{ $availability->day_of_week }}</td>
                                    <td>{{ $availability->timeslot }}</td>
                                    <td class="text-right">
                                        <form method="POST" action="{{ route('counselor.availability.destroy', $availability) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-outline btn-xs rounded-full"
                                                onclick="return confirm('Remove this availability?');"
                                            >
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('availability-search');
    const table = document.getElementById('availability-table');
    if (!input || !table) return;

    const sortState = { column: null, direction: 'asc' };

    const applyFilter = () => {
        const query = input.value.trim().toLowerCase();
        const rows = Array.from(table.querySelectorAll('tbody tr'));

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
            if (key === 'day') {
                return Number(row.dataset.dayOrder || 99);
            }
            return (row.dataset[key] || '').toLowerCase();
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

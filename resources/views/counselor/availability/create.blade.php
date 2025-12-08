@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6 max-w-3xl">
        <div>
            <p class="text-xs uppercase text-gray-500 tracking-wide">Availability</p>
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                Add Availability
            </h1>
            <p class="text-sm text-gray-500">
                Choose the day and time range when you can accept bookings.
            </p>
        </div>

        <div class="card bg-base-100 shadow-md rounded-2xl border border-base-200">
            <div class="card-body space-y-4">
                <form method="POST" action="{{ route('counselor.availability.store') }}" class="space-y-4">
                    @csrf

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Day of week</span>
                            </label>
                            <select name="day_of_week" class="select select-bordered" required>
                                <option value="" disabled selected>Select a day</option>
                            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                                <option value="{{ $day }}" {{ old('day_of_week') === $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                        @error('day_of_week')
                            <span class="text-xs text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Timeslots (add multiple for the same day)</span>
                        </label>
                        <div id="timeslotList" class="space-y-2">
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    name="timeslot[]"
                                    value="{{ old('timeslot.0') }}"
                                    placeholder="e.g., 09:00-12:00 AM"
                                    class="input input-bordered w-full"
                                    required
                                />
                            </div>
                            @if(old('timeslot'))
                                @foreach(array_slice(old('timeslot'), 1) as $slot)
                                    <div class="flex gap-2">
                                        <input
                                            type="text"
                                            name="timeslot[]"
                                            value="{{ $slot }}"
                                            placeholder="e.g., 01:00-03:00 PM"
                                            class="input input-bordered w-full"
                                        />
                                        <button type="button" class="btn btn-ghost btn-sm remove-timeslot">Remove</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="addTimeslot" class="btn btn-ghost btn-sm mt-2">
                            + Add another timeslot
                        </button>
                        @error('timeslot')
                            <span class="text-xs text-error mt-1">{{ $message }}</span>
                        @enderror
                        @error('timeslot.*')
                            <span class="text-xs text-error mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-wrap gap-2 justify-end">
                        <a href="{{ route('counselor.availability.index') }}" class="btn btn-ghost btn-sm rounded-full">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-full">
                            Save Availability
                        </button>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const list = document.getElementById('timeslotList');
    const addBtn = document.getElementById('addTimeslot');

    addBtn?.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'flex gap-2 mt-1';
        row.innerHTML = `
            <input
                type="text"
                name="timeslot[]"
                placeholder="e.g., 02:00-05:00 PM"
                class="input input-bordered w-full"
            />
            <button type="button" class="btn btn-ghost btn-sm remove-timeslot">Remove</button>
        `;
        list.appendChild(row);
    });

    list?.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-timeslot')) {
            e.preventDefault();
            const row = e.target.closest('.flex');
            row?.remove();
        }
    });
});
</script>
@endpush

{{-- resources/views/appointments/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        {{-- Heading --}}
        <div class="text-center space-y-2">
            <p class="text-xs uppercase tracking-[0.2em] text-primary/80">
                Book a Session
            </p>
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                Book Your Counseling Session
            </h1>
            <p class="text-sm text-gray-500 max-w-xl mx-auto">
                Fill out the form below to schedule a session with a professional counselor.
            </p>
        </div>

        {{-- Card --}}
        <div class="card bg-gradient-to-br from-white via-[#f8f5ff] to-[#f3faff] shadow-xl rounded-3xl border border-base-200">
            <div class="card-body space-y-6">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10">
                        📋
                    </span>
                    <div>
                        <h2 class="text-base font-semibold text-gray-800">
                            Session Details
                        </h2>
                        <p class="text-xs text-gray-500">
                            We’ll use this to match you with the right counselor and time.
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                    @csrf

                    {{-- Personal Information (read-only from auth) --}}
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10">
                                👤
                            </span>
                            <p class="font-medium text-sm text-gray-700">Your Information</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">Full Name</span>
                                </label>
                                <input
                                    type="text"
                                    class="input input-bordered w-full rounded-xl bg-base-200/60"
                                    value="{{ old('name', auth()->user()->name ?? '') }}"
                                    disabled
                                >
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">Email</span>
                                </label>
                                <input
                                    type="email"
                                    class="input input-bordered w-full rounded-xl bg-base-200/60"
                                    value="{{ old('email', auth()->user()->email ?? '') }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control md:col-span-2">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">
                                        Phone Number (optional)
                                    </span>
                                </label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="input input-bordered w-full rounded-xl"
                                    placeholder="+63 900 000 0000"
                                    value="{{ old('phone') }}"
                                >
                                @error('phone')
                                    <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="divider my-2"></div>

                    {{-- Session Preferences --}}
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10">
                                📅
                            </span>
                            <p class="font-medium text-sm text-gray-700">Session Preferences</p>
                        </div>

                        {{-- Counselor + Session Type --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">Select Counselor</span>
                                </label>
                                <select
                                    class="select select-bordered w-full rounded-xl"
                                    name="counselor_id"
                                    id="counselorSelect"
                                >
                                    <option value="" disabled {{ old('counselor_id') ? '' : 'selected' }}>
                                        Choose a counselor
                                    </option>
                                    @foreach($counselors as $counselor)
                                        <option
                                            value="{{ $counselor->id }}"
                                            @selected(old('counselor_id', request('counselor')) == $counselor->id)
                                        >
                                            {{ $counselor->name }} — {{ $counselor->occupation ?? 'Counselor' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('counselor_id')
                                    <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">Session Type</span>
                                </label>
                                <select
                                    class="select select-bordered w-full rounded-xl"
                                    name="appointment_session_id"
                                >
                                    <option value="" disabled {{ old('appointment_session_id') ? '' : 'selected' }}>
                                        Choose session type
                                    </option>
                                    @foreach($sessions as $session)
                                        <option
                                            value="{{ $session->id }}"
                                            @selected(old('appointment_session_id') == $session->id)
                                        >
                                            {{ $session->title }} - {{ $session->duration }} min
                                        </option>
                                    @endforeach
                                </select>
                                @error('appointment_session_id')
                                    <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Appointment category --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">Appointment Category</span>
                            </label>
                            <select
                                name="appointment_type"
                                class="select select-bordered w-full rounded-xl"
                            >
                                <option value="" disabled {{ old('appointment_type') ? '' : 'selected' }}>
                                    Select a category
                                </option>
                                <option value="individual_counseling" @selected(old('appointment_type') === 'individual_counseling')>Individual Counseling</option>
                                <option value="couples_counseling" @selected(old('appointment_type') === 'couples_counseling')>Couples Counseling</option>
                                <option value="family_counseling" @selected(old('appointment_type') === 'family_counseling')>Family Counseling</option>
                                <option value="group_therapy" @selected(old('appointment_type') === 'group_therapy')>Group Therapy</option>
                            </select>
                            @error('appointment_type')
                                <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Date + Time --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">Preferred Date</span>
                                </label>
                                <input
                                    type="date"
                                    name="session_date"
                                    id="sessionDate"
                                    class="input input-bordered w-full rounded-xl"
                                    value="{{ old('session_date', now()->addDay()->format('Y-m-d')) }}"
                                >
                                @error('session_date')
                                    <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-xs font-medium text-gray-600">Available Time</span>
                                </label>
                                <select
                                    name="session_time"
                                    id="sessionTime"
                                    class="select select-bordered w-full rounded-xl"
                                >
                                    <option value="" disabled selected>
                                        Select a time
                                    </option>
                                    {{-- options filled via JS --}}
                                </select>
                                <label class="label">
                                    <span id="timeHelpText" class="label-text-alt text-[11px] text-gray-400">
                                        Select a counselor and date to see available time slots.
                                    </span>
                                </label>
                                @error('session_time')
                                    <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-xs font-medium text-gray-600">
                                    Session Notes (optional)
                                </span>
                            </label>
                            <textarea
                                name="notes"
                                class="textarea textarea-bordered w-full rounded-xl min-h-[90px]"
                                placeholder="Briefly share what you’d like to focus on in this session."
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-wrap justify-end gap-3 pt-2">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-ghost btn-sm rounded-full">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-full">
                            Confirm Booking
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
    const counselorSelect = document.getElementById('counselorSelect');
    const dateInput = document.getElementById('sessionDate');
    const timeSelect = document.getElementById('sessionTime');
    const helpText = document.getElementById('timeHelpText');

    async function loadSlots() {
        const counselorId = counselorSelect.value;
        const date = dateInput.value;

        if (!counselorId || !date) return;

        timeSelect.innerHTML = '<option disabled selected>Loading...</option>';
        helpText.textContent = 'Fetching available time slots...';

        try {
            const response = await fetch(`/api/counselors/${counselorId}/available-slots?date=${date}`);
            const data = await response.json();

            timeSelect.innerHTML = '';

            if (!data.slots || data.slots.length === 0) {
                timeSelect.innerHTML = '<option disabled selected>No available slots for this day.</option>';
                helpText.textContent = 'Try a different date or counselor.';
                return;
            }

            data.slots.forEach(slot => {
                const opt = document.createElement('option');
                opt.value = slot; // if you later store ranges, you can split this
                opt.textContent = slot;
                timeSelect.appendChild(opt);
            });

            helpText.textContent = `Showing available slots for ${data.day_of_week}, ${data.date}.`;
        } catch (e) {
            timeSelect.innerHTML = '<option disabled selected>Error loading slots.</option>';
            helpText.textContent = 'Please try again or contact support.';
        }
    }

    counselorSelect?.addEventListener('change', loadSlots);
    dateInput?.addEventListener('change', loadSlots);

    // Auto-load if counselor preselected from "View Schedule & Book"
    if (counselorSelect && counselorSelect.value) {
        loadSlots();
    }
});
</script>
@endpush

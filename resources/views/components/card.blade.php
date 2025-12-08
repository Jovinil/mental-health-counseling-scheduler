@props([
    'counselors' => 'counselors',
    'appointmentType' => 'appointmentType',
])

<div class="flex flex-col bg-accent shadow-xl/50 shadow-indigo-500/50">
    <!-- Header -->
    <div class="bg-gray-100 rounded-t-lg p-4 text-white border-b border-b-gray-400">
        <h1 class="text-xl text-accent font-bold">Session Details</h1>
        <p class="text-gray-200 font-thin">Please provide your information and preferences</p>
    </div>

    <!-- Body -->
    <div class="flex flex-col gap-3 bg-gray-50 rounded-b-lg p-4">

        <h2 class="font-semibold">Personal Information</h2>

        <!-- Full Name -->
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Full Name *</span>
            </label>
            <input type="text" class="input input-bordered w-full" name="fullname">
        </div>

        <!-- Email -->
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Email *</span>
            </label>
            <input type="email" class="input input-bordered w-full" name="email">
        </div>

        <!-- Phone -->
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Phone Number *</span>
            </label>
            <input type="text" class="input input-bordered w-full" name="phone">
        </div>

        <x-divider />

        <h2 class="font-semibold">Session Preferences</h2>

        <!-- COUNSELOR DROPDOWN -->
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Counselor *</span>
            </label>

            <div class="dropdown w-full">
                <div tabindex="0" role="button"
                    class="btn w-full justify-between normal-case">
                    Select Counselor
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <ul tabindex="0"
                    class="dropdown-content z-1 menu p-2 shadow bg-base-100 rounded-box w-full">
                    @foreach ($counselors as $counselor)
                        <li><p>{{ $counselor->name }}</p></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- SESSION DROPDOWN -->
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Session Type *</span>
            </label>

            <div class="dropdown w-full">
                <div tabindex="0" role="button"
                    class="btn w-full justify-between normal-case">
                    Select Session
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="dropdown-content z-1 menu p-2 shadow bg-base-100 rounded-box w-full">
                    <li><p>Individual Counseling (60 min)</p></li>
                    <li><p>Couples Counseling (90 min)</p></li>
                    <li><p>Family Counseling (90 min)</p></li>
                    <li><p>Group Therapy (90 min)</p></li>
                </ul>
            </div>
        </div>

        <!-- DATE & TIME -->
        <div class="w-full flex gap-6">
            <x-date-picker label="Preferred Date" name="session_date" />

            <x-time-dropdown :times="['08:00 AM', '09:30 AM', '01:30 PM']"
                label="Preferred Time"
                name="session_time" />
        </div>

        <x-divider />

        <h2 class="font-semibold">Additional Information</h2>

        <div class="form-control">
            <label class="label">
                <span class="label-text">Notes or Concerns (Optional)</span>
            </label>
            <textarea class="textarea textarea-bordered"
                      placeholder="Share any specific concerns or topics you'd like to discuss...">
            </textarea>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#counselor_select').on('change', function () {
        const counselorId = $(this).val();

        if (!counselorId) return;

        $.ajax({
            url: `/counselor/${counselorId}/availability`,
            type: 'GET',
            success: function (data) {
                $('#availability_select').empty();

                if (data.length === 0) {
                    $('#availability_select').append(
                        `<option disabled selected>No available schedule</option>`
                    );
                    return;
                }

                data.forEach(item => {
                    $('#availability_select').append(`
                        <option value="${item.id}">
                            ${item.day_of_week} — ${item.start_time} to ${item.end_time}
                        </option>
                    `);
                });
            }
        });
    });
});
</script>

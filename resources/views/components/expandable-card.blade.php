@props([
    'counselor_name' => 'Counselor Name',
    'occupation' => 'Occupation',
    'specialties' => 'Specialties',
    'experience' => 'Experience',
    'languages' => 'Languages Spoken',
    'description' => 'Description',
])

<div

    x-data="{ open: false }"
    {{ $attributes->merge(['class' => 'bg-gray-50 hover:shadow-xl/50 shadow-lg/50 shadow-indigo-500/50 rounded-xl border border-gray-200 w-full h-full pb-4']) }}
>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-between w-full rounded-xl">
        <div class="bg-gray-100 flex justify-between w-full rounded-t-xl p-4">
            <div class="flex gap-3">
                profile
                <span>
                    <h1>{{ $counselor_name }}</h1>
                    <h2>{{ $occupation }}</h2>
                </span>

            </div>

            <div>
                rating (stars)
            </div>
        </div>

        <div class="w-full p-4 flex flex-col gap-3">
            <div class="flex gap-3">
                {{ $specialties }}
            </div>

            <div>
                {{ $description }}
            </div>

            <x-divider />

            <div class="flex gap-30 items-center w-full bg-gray-">
                <span>{{ $experience }} years experience</span>
                <span>{{ $languages }}</span>

            </div>
        </div>

        <div class="w-full px-4">
            <button
                @click="open = !open"
                class="px-3 py-1 text-sm rounded-full w-full bg-blue-200 hover:bg-blue-300 transition"
            >
                <span x-show="!open">Show</span>
                <span x-show="open">Hide</span>
            </button>

        </div>
    </div>

    <!-- Expandable Content -->
    <div
        x-show="open"
        x-transition
        class="mt-4 px-4 text-gray-700"
    >
        <h1>Weekly Availability</h1>

        <x-tabs :tabs="[
            'overview' => 'Overview',
            'schedule' => 'Schedule',
            'reviews' => 'Reviews'
        ]" initial="overview"
        name="{{ $counselor_name }}">

            <div x-show="activeTab === 'overview'" x-transition>
                This is the overview content.
            </div>

            <div x-show="activeTab === 'schedule'" x-transition>
                Counselors’ schedules go here.
            </div>

            <div x-show="activeTab === 'reviews'" x-transition>
                User reviews go here.
            </div>

        </x-tabs>

    </div>
</div>

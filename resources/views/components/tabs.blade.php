@props([
    'tabs' => [], // ['overview' => 'Overview', 'reviews' => 'Reviews']
    'initial' => null,
    'name' => 'Counselor',
])

<div x-data="{ activeTab: '{{ $initial ?? array_key_first($tabs) }}' }" class="w-full">

    <!-- TAB BUTTONS -->
    <div class="flex gap-2 items-center justify-center">
        <div class="w-auto h-auto flex gap-2 flex-1 justify-between items-center p-1 bg-gray-200 rounded-md">
            @foreach ($tabs as $key => $label)
            <div class="flex-1 flex items-center justify-center rounded-md"
                :class="activeTab === '{{ $key }}' ? 'bg-white' : ''">
                <button
                    @click="activeTab = '{{ $key }}'"
                    class="px-2 py-1 text-sm font-medium rounded-xl transition"
                    :class="activeTab === '{{ $key }}'
                        ? 'bg-white text-gray-950'
                        : ' text-gray-500 hover:bg-gray-200'"
                >
                    {{ $label }}
                </button>
            </div>

            @endforeach
        </div>
    </div>

    <!-- TAB CONTENT -->
    <div class="p-4">
        {{ $slot }}

    </div>

    <div>
        <button href="/" variant="ghost" icon="home"
        class="rounded-full! text-white! px-2 py-1 w-full  bg-linear-to-r from-blue-300 via-blue-500 to-purple-500
    hover:opacity-90 transition ">
    Book session with {{ $name }}</button>
    </div>
</div>

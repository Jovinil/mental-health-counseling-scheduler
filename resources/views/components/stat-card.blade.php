@props([
    'label' => '',
    'value' => '',
    'icon' => null,   {{-- optional Heroicon / Lucide class --}}
])

<div class="card bg-base-100 shadow-md border border-base-200 rounded-2xl">
    <div class="card-body px-5 py-4 flex flex-row items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">{{ $label }}</p>
            <p class="text-2xl font-semibold text-gray-800">{{ $value }}</p>
        </div>
        @if($icon)
            <div class="btn btn-circle btn-sm btn-ghost">
                <x-dynamic-component :component="$icon" class="w-5 h-5" />
            </div>
        @endif
    </div>
</div>

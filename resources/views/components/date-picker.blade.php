@props([
    'label' => 'Select Date',
])

<div x-data class="w-full">
    <label class="block mb-1 text-sm font-medium text-gray-700">
        {{ $label }}
    </label>

    <input
        type="date"
        {{ $attributes->merge([
            'class' => 'w-full rounded-lg border border-gray-300 px-3 py-2
                        focus:ring-2 focus:ring-blue-400 focus:border-blue-400
                        bg-white'
        ]) }}
    >
</div>

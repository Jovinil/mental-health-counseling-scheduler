@props([
    'label' => 'Available Time',
    'times' => [''],
])

<div class="w-full">
    <label class="block mb-1 text-sm font-medium text-gray-700">
        {{ $label }}
    </label>

    <flux:dropdown class="flex" position="bottom" align="start">

        {{-- Trigger Button --}}
        <flux:button
            class="w-full justify-between! text-left"
            icon:trailing="chevron-down"
        >
            Select Time
        </flux:button>

        {{-- Menu List --}}
        <flux:menu>
            @foreach ($times as $time)
                <flux:menu.item class="w-full" wire:click="$set('selectedTime', '{{ $time }}')">
                    {{ $time }}
                </flux:menu.item>
            @endforeach
        </flux:menu>

    </flux:dropdown>
</div>

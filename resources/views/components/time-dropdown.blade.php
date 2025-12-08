@props([
    'label' => 'Available Time',
    'times' => [''],
])

<div class="w-full">
    <label class="block mb-1 text-sm font-medium text-gray-700">
        {{ $label }}
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
           @foreach ($times as $time)
               <li><a>{{ $time }}</a></li>
           @endforeach
        </ul>
    </div>
</div>

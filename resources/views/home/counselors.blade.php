@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        {{-- Page heading --}}
        <div class="text-center space-y-3">
            <p class="text-xs uppercase tracking-[0.2em] text-primary/70">MindCare</p>
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                Our Expert Counselors
            </h1>
            <p class="max-w-2xl mx-auto text-sm text-gray-500">
                Meet our team of licensed professionals dedicated to supporting your mental health journey.
            </p>
        </div>

        {{-- Cards grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($counselors as $counselor)
                @php
                    // Group availability by day_of_week for this counselor
                    $availabilityByDay = $counselor->availabilities
                        ? $counselor->availabilities->groupBy('day_of_week')
                        : collect();
                @endphp

                <div class="card bg-base-100 shadow-lg rounded-3xl border border-base-200/80 overflow-hidden">
                    <div class="card-body space-y-4">

                        {{-- Header: avatar, name, rating --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="w-14 rounded-full ring ring-primary/10 ring-offset-2">
                                        <img
                                            src="{{ $counselor->profile_image ?? 'https://ui-avatars.com/api/?name='.urlencode($counselor->name).'&background=random' }}"
                                            alt="{{ $counselor->name }}"
                                        />
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm md:text-base">
                                        {{ $counselor->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $counselor->occupation ?? 'Licensed Counselor' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-1">
                                <span class="badge badge-warning badge-outline text-[11px] px-3">
                                    ⭐ {{ number_format($counselor->rating ?? 4.9, 1) }}
                                </span>
                                <span class="text-[10px] text-gray-400">
                                    {{ $counselor->rating_count ?? 150 }} reviews
                                </span>
                            </div>
                        </div>

                        {{-- Specialties tags --}}
                        @php
                            $tags = $counselor->specialties
                                ? explode(',', $counselor->specialties)
                                : [];
                        @endphp
                        @if(count($tags))
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $tag)
                                    <div class="badge badge-outline rounded-full text-[11px] px-3 py-2 bg-base-200/50">
                                        {{ trim($tag) }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Description --}}
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ $counselor->description
                                ?? 'This counselor specializes in evidence-based approaches to help clients achieve better emotional well-being.' }}
                        </p>

                        {{-- Meta row: experience + languages --}}
                        <div class="flex flex-wrap gap-4 text-xs text-gray-500">
                            @if($counselor->years_of_experience)
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10">
                                        ⏳
                                    </span>
                                    <span>{{ $counselor->years_of_experience }} years experience</span>
                                </div>
                            @endif

                            @if($counselor->languages)
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10">
                                        🌐
                                    </span>
                                    <span>{{ $counselor->languages }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Weekly Availability - expandable --}}
                        @if($availabilityByDay->isNotEmpty())
                            <div class="border border-base-200 rounded-2xl bg-base-100/70">
                                <div class="collapse collapse-arrow rounded-2xl">
                                    <input type="checkbox" />
                                    <div class="collapse-title text-xs font-semibold text-gray-700 flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10">
                                            📆
                                        </span>
                                        Weekly Availability
                                    </div>
                                    <div class="collapse-content pt-0 pb-4 px-4">
                                        {{-- Day tabs-like layout --}}
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @foreach($availabilityByDay->keys() as $day)
                                                <span class="badge badge-outline rounded-full text-[11px] px-3 py-2">
                                                    {{ $day }}
                                                </span>
                                            @endforeach
                                        </div>

                                        {{-- Slots per day --}}
                                        <div class="space-y-3">
                                            @foreach($availabilityByDay as $day => $slots)
                                                <div class="flex flex-col gap-1">
                                                    <p class="text-[11px] font-semibold text-gray-500 mb-1">
                                                        {{ $day }}
                                                    </p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($slots as $slot)
                                                            <button
                                                                type="button"
                                                                class="btn btn-xs rounded-full bg-emerald-50 border-emerald-100 text-emerald-700 hover:bg-emerald-100">
                                                                {{ $slot->timeslot }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="pt-1 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                            <a href="{{ route('appointments.create', ['counselor' => $counselor->id]) }}"
                               class="btn btn-outline btn-sm rounded-full border-primary/70 text-primary w-full sm:w-auto"
                               data-requires-login>
                                View Full Schedule &amp; Book
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            {{ $counselors->links() }}
        </div>
    </div>
@endsection

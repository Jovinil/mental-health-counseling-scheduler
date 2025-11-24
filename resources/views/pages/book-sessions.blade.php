@extends('layouts.app')

@section('content')

<div class="flex flex-col gap-2 my-3 items-center justify-center">

    <h1>Book Your Counseling Session.</h1>
    <p>Fill out the form below to schedule your appointment with a professional counselor</p>

    <div class="w-3/4">
        <x-card >
            <ul class="list-disc ml-5 space-y-1">
                <li>Monday – 9:00 AM to 3:00 PM</li>
                <li>Tuesday – 10:00 AM to 4:00 PM</li>
                <li>Friday – 8:00 AM to 12:00 PM</li>
            </ul>
        </x-card>
    </div>
</div>

@endsection

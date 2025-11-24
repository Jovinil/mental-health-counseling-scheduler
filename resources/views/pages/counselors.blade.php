@extends('layouts.app')

@section('content')

<div class="flex flex-col gap-2 my-3 items-center justify-center">

    <h1>Our Expert Counselors</h1>
    <p>Meet our team of licensed professionals dedicated to your mental health journey</p>

    <div class="grid grid-cols-1 md:grid-cols-2 w-full mt-4 px-4 gap-5">
        <div>
            <x-expandable-card
                title="Dr. Jane Smith"
                counselor_name="Dr. Jane Smith"
                occupation="Licensed Clinical Psychologist"
                specialties="Cognitive Behavioral Therapy, Anxiety, Depression"
                description="With over 15 years of experience, Dr. Smith specializes in helping individuals overcome anxiety and depression through evidence-based practices."
                experience="15"
                languages="English, Spanish"
                >
            </x-expandable-card>
        </div>

        <div>
            <x-expandable-card
                title="Dr. Jane Smith"
                counselor_name="Dr. Jane Smith"
                occupation="Licensed Clinical Psychologist"
                specialties="Cognitive Behavioral Therapy, Anxiety, Depression"
                description="With over 15 years of experience, Dr. Smith specializes in helping individuals overcome anxiety and depression through evidence-based practices."
                experience="15"
                languages="English, Spanish"
                >
            </x-expandable-card>
        </div>

         <div>
            <x-expandable-card
                title="Dr. Jane Smith"
                counselor_name="Dr. Jane Smith"
                occupation="Licensed Clinical Psychologist"
                specialties="Cognitive Behavioral Therapy, Anxiety, Depression"
                description="With over 15 years of experience, Dr. Smith specializes in helping individuals overcome anxiety and depression through evidence-based practices."
                experience="15"
                languages="English, Spanish"
                >
            </x-expandable-card>
        </div>

        <div>
            <x-expandable-card
                title="Dr. Jane Smith"
                counselor_name="Dr. Jane Smith"
                occupation="Licensed Clinical Psychologist"
                specialties="Cognitive Behavioral Therapy, Anxiety, Depression"
                description="With over 15 years of experience, Dr. Smith specializes in helping individuals overcome anxiety and depression through evidence-based practices."
                experience="15"
                languages="English, Spanish"
                >
            </x-expandable-card>
        </div>
    </div>
</div>

@endsection

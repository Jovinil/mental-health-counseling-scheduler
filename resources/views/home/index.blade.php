@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-16">
        {{-- Hero --}}
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-6">
                <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.15em] text-primary/80 bg-primary/10 px-3 py-1 rounded-full w-max">
                    <span>MindCare</span>
                    <span class="text-[10px] bg-primary text-white px-2 py-0.5 rounded-full">NEW</span>
                </p>
                <h1 class="text-3xl md:text-4xl font-bold leading-tight text-gray-900">
                    Smarter Appointment Scheduling <br class="hidden md:block" />
                    <span class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">
                        for Therapists and Counselors
                    </span>
                </h1>
                <p class="text-gray-600 text-base md:text-lg max-w-2xl">
                    Manage therapy appointments with automated scheduling, reminders, and client self-booking.
                    Focus on growing your practice instead of admin work.
                </p>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('user.register') }}" class="btn btn-primary rounded-full px-6">Start free trial</a>
                    <a href="{{ route('user.login') }}" class="btn btn-ghost rounded-full px-6">Login</a>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                    No credit card required. Cancel anytime.
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-6 bg-gradient-to-r from-indigo-100 via-purple-100 to-pink-100 blur-2xl opacity-60"></div>
                <div class="relative bg-white border border-base-200 shadow-2xl rounded-3xl overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-base-200 bg-base-100">
                        <div class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-500">ST</span>
                            MindCare
                        </div>
                        <div class="text-xs text-gray-500">Booking view</div>
                    </div>
                    <div class="grid grid-cols-[220px_1fr]">
                        <div class="border-r border-base-200 bg-base-50 p-4 space-y-4 text-sm text-gray-600">
                            <div class="font-semibold text-gray-800">Menu</div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-2 text-indigo-600 font-semibold">
                                    <span class="inline-block w-2 h-2 rounded-full bg-indigo-500"></span> Dashboard
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-slate-300"></span> Appointments
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-slate-300"></span> Clients
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-slate-300"></span> Settings
                                </div>
                            </div>
                            <div class="mt-6 p-3 rounded-xl bg-orange-50 border border-orange-100 text-xs text-orange-700">
                                <div class="font-semibold">Upgrade to Pro</div>
                                <p>Get automated reminders and custom branding.</p>
                            </div>
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">Your existing services</p>
                                    <p class="text-sm font-semibold text-gray-800">Individual Therapy</p>
                                </div>
                                <span class="badge badge-outline badge-primary">Live</span>
                            </div>

                            <div class="space-y-3">
                                @foreach([
                                    ['title' => '1 session (60min)', 'price' => '$120', 'promo' => '10% off for 5-session bundle'],
                                    ['title' => '5 sessions bundle', 'price' => '$540', 'promo' => 'Save $60'],
                                    ['title' => 'Intake session', 'price' => '$150', 'promo' => 'Includes assessment']
                                ] as $service)
                                    <div class="border border-base-200 rounded-2xl p-4 flex items-center justify-between bg-base-100 hover:shadow-sm transition">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $service['title'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $service['promo'] }}</p>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-800">{{ $service['price'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Pain points & visual --}}
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-4">
                <p class="text-sm uppercase tracking-[0.15em] text-primary/80 font-semibold">Tired of dealing with</p>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="text-green-500">•</span>
                        Back-and-forth calls to confirm times
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-500">•</span>
                        Constant reschedules mid-day
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-500">•</span>
                        Double-booking or missing a client
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-green-500">•</span>
                        Missed appointments due to no reminders
                    </li>
                </ul>
                <p class="text-sm text-gray-500">
                    Small interruptions add up, taking hours away from your week and adding stress to your practice.
                </p>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 bg-indigo-100 rounded-3xl blur-2xl opacity-60"></div>
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=900&q=80" class="relative rounded-3xl border border-base-200 shadow-xl" alt="Desk with paperwork" />
            </div>
        </section>

        {{-- Solution grid --}}
        <section class="space-y-8">
            <div class="text-center space-y-2">
                <p class="text-sm uppercase tracking-[0.2em] text-primary/80 font-semibold">Here is a solution for you</p>
                <p class="text-base text-gray-500">MindCare automates the entire scheduling process</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach([
                    ['title' => 'Automated Booking', 'desc' => 'Clients book sessions themselves online.', 'icon' => '↺'],
                    ['title' => 'Automated Reminders', 'desc' => 'Send SMS/email reminders and reduce no-shows.', 'icon' => '✉'],
                    ['title' => 'Easy Rescheduling', 'desc' => 'Manage changes without back-and-forth calls.', 'icon' => '⏱'],
                    ['title' => 'Google Calendar Sync', 'desc' => 'Keep schedules aligned across devices.', 'icon' => '📅'],
                    ['title' => 'Real-Time Availability', 'desc' => 'Avoid double-booking with live time slots.', 'icon' => '🟢'],
                    ['title' => 'Client Portal', 'desc' => 'Clients view notes, book, and manage appointments easily.', 'icon' => '👤'],
                ] as $feature)
                    <div class="card bg-base-100 shadow-sm border border-base-200">
                        <div class="card-body space-y-2">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary text-lg">
                                {{ $feature['icon'] }}
                            </div>
                            <h3 class="font-semibold text-gray-800">{{ $feature['title'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $feature['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Result highlight --}}
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center bg-base-100 rounded-3xl border border-base-200 p-8 shadow-sm">
            <div class="space-y-4">
                <p class="text-sm uppercase tracking-[0.15em] text-primary/80 font-semibold">The Result</p>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start gap-2"><span class="text-green-500">✔</span> More time for client care</li>
                    <li class="flex items-start gap-2"><span class="text-green-500">✔</span> Fewer no-shows and missed appointments</li>
                    <li class="flex items-start gap-2"><span class="text-green-500">✔</span> A calmer, more organized workday</li>
                </ul>
                <a href="{{ route('user.register') }}" class="btn btn-primary btn-sm rounded-full w-max">Save hours every week</a>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 bg-purple-100 rounded-3xl blur-2xl opacity-60"></div>
                <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=900&q=80" class="relative rounded-3xl border border-base-200 shadow-xl" alt="Counselor with client" />
            </div>
        </section>

        {{-- Why MindCare --}}
        <section class="space-y-6">
            <div class="space-y-2">
                <p class="text-sm uppercase tracking-[0.15em] text-primary/80 font-semibold">Why MindCare</p>
                <h2 class="text-2xl font-semibold text-gray-900">Built for therapists</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach([
                    ['title' => 'Built for Therapists', 'desc' => 'Designed with mental health practices in mind. Simple, intuitive, and secure.'],
                    ['title' => 'All-in-One', 'desc' => 'Scheduling, notes, payments, reminders, and secure messaging in one place.'],
                    ['title' => 'Data Security', 'desc' => 'HIPAA-ready mindset and best-practice security for sensitive data.'],
                ] as $why)
                    <div class="card bg-base-100 border border-base-200 shadow-sm">
                        <div class="card-body space-y-2">
                            <h3 class="font-semibold text-gray-800">{{ $why['title'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $why['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Testimonials --}}
        <section class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <p class="text-sm uppercase tracking-[0.15em] text-primary/80 font-semibold">What therapists say</p>
                    <h2 class="text-xl font-semibold text-gray-900">Trusted by practitioners</h2>
                </div>
                <a href="{{ route('user.register') }}" class="btn btn-outline btn-sm rounded-full">Start 14-day free trial</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach([
                    ['name' => 'Sana Au', 'role' => 'Counselor & Case Care', 'quote' => 'The scheduling automation and reminders have been essential for our practice.'],
                    ['name' => 'Cheryl Kong', 'role' => 'Licensed Counselor', 'quote' => 'Fewer no-shows, happier clients, and a calmer workday.'],
                    ['name' => 'Dr. Nicole Chen', 'role' => 'Clinical Psychologist', 'quote' => 'Self-booking plus reminders dramatically reduced admin time.'],
                ] as $t)
                    <div class="card bg-base-100 shadow-sm border border-base-200">
                        <div class="card-body space-y-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr($t['name'], 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $t['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $t['role'] }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700">“{{ $t['quote'] }}”</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- CTA --}}
        <section class="rounded-3xl border border-base-200 bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-sm">
            <div>
                <p class="text-xs uppercase tracking-[0.15em] text-primary/80 font-semibold">Digitizing mental health</p>
                <h3 class="text-xl font-semibold text-gray-900">Start your 14-day free trial</h3>
                <p class="text-sm text-gray-600">No credit card required. See if it works for you.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('user.register') }}" class="btn btn-primary rounded-full">Start free trial</a>
                <a href="{{ route('user.login') }}" class="btn btn-ghost rounded-full">Login</a>
            </div>
        </section>
    </div>
@endsection

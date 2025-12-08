<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'MindCare' }}</title>

    {{-- Tailwind + DaisyUI (via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-linear-to-br from-[#f4f2ff] via-[#fdfbff] to-[#f2fbff] min-h-screen">
    <div class="min-h-screen flex flex-col">
        {{-- Top Navbar --}}
        {{-- @include('layouts.header') --}}

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success shadow-lg max-w-4xl mx-auto mt-4">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error shadow-lg max-w-4xl mx-auto mt-4">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 w-full max-w-6xl mx-auto px-4 lg:px-0 py-8">
            @yield('content')
        </main>

        <footer class="footer footer-center p-4 bg-transparent text-base-content text-xs mt-6">
            <div>
                <p>© {{ date('Y') }} MindCare — Mental Health Counseling Scheduler</p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>

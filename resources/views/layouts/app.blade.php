<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @livewireStyles
    {{-- @fluxAppearance --}}
    <title>Document</title>

</head>
<body>
    <div class="min-h-screen flex flex-col">
        @include('layouts.header')

        <main class="bg-gray-100 dark:bg-gray-800 flex-1 px-15 py-6">
            @yield('content')
        </main>
    </div>

    @livewireScripts
    @fluxScripts
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>

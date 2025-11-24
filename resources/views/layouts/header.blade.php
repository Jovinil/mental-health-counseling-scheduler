<nav class="h-15 bg-gray-50 dark:bg-gray-900 flex justify-between items-center px-15">

    <div>
        <h1 class="text-3xl font-bold
    bg-linear-to-r from-blue-300 via-blue-500 to-purple-500
    bg-clip-text text-transparent">
            MindCare
        </h1>
    </div>

    <div class="flex gap-5">
        <flux:button href="/" variant="ghost" icon="home" class="rounded-full! text-white! py-0!  bg-linear-to-r from-blue-300 via-blue-500 to-purple-500
    hover:opacity-90 transition">Home</flux:button>
        <flux:button href="/book" variant="ghost" icon="puzzle-piece" class="rounded-full!">Book Session</flux:button>
        <flux:button href="/counselors" variant="ghost" icon="user" class="rounded-full!">Counselors</flux:button>
    </div>
    {{-- <flux:navbar>

        <flux:navbar.item href="/" variant="filled" icon="home">Home</flux:navbar.item>
        <flux:navbar.item href="#" variant="filled" icon="puzzle-piece">Features</flux:navbar.item>
        <flux:navbar.item href="#" variant="filled" icon="user">About</flux:navbar.item>
    </flux:navbar> --}}
</nav>

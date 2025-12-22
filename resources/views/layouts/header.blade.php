{{-- Top Navbar (Responsive) --}}
<nav class="navbar bg-base-100/70 backdrop-blur shadow-sm px-4 sm:px-6 lg:px-12 sticky top-0 z-50">
    {{-- Left: Brand --}}
    <div class="flex-1">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="avatar placeholder">
                <div class="bg-primary text-primary-content rounded-full w-10">
                    <span class="text-lg font-bold">M</span>
                </div>
            </div>
            <span class="font-semibold text-lg tracking-tight">MindCare</span>
        </a>
    </div>

    {{-- Right: Mobile menu + Desktop menu + Avatar --}}
    <div class="flex items-center gap-2">

        {{-- ✅ MOBILE: Hamburger (hidden on md+) --}}
        <div class="dropdown dropdown-end md:hidden">
            <label tabindex="0" class="btn btn-ghost btn-circle">
                {{-- hamburger icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </label>

            <ul tabindex="0"
                class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-60 z-[60]">
                
                {{-- Client/Guest Links (only when NOT counselor) --}}
                @if (!auth('counselor')->check())
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('appointments.create') }}" data-requires-login>Book Session</a></li>
                    <li><a href="{{ route('counselors.index') }}">Counselors</a></li>
                    @if (auth()->check())
                        <li><a href="{{ route('appointments.index') }}">My Appointments</a></li>
                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    @endif
                @endif

                {{-- Counselor Links --}}
                @if(auth('counselor')->check())
                    <li><a href="{{ route('counselor.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('counselor.appointments.index') }}">My Appointments</a></li>
                    <li><a href="{{ route('counselor.availability.index') }}">My Availability</a></li>
                @endif

                {{-- Auth actions --}}
                @if(auth()->check())
                    <li class="mt-1">
                        <button type="submit" form="logout-form" class="w-full text-left">
                            Logout
                        </button>
                    </li>
                @elseif(auth('counselor')->check())
                    <li class="mt-1">
                        <button type="submit" form="counselor-logout-form" class="w-full text-left">
                            Logout
                        </button>
                    </li>
                @else
                    {{-- Optional guest actions (uncomment if you have routes) --}}
                    {{-- <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li> --}}
                @endif
            </ul>
        </div>

        {{-- ✅ DESKTOP: Menus (hidden below md) --}}
        @if (!auth('counselor')->check())
            <ul class="menu menu-horizontal px-1 hidden md:flex">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('appointments.create') }}" data-requires-login>Book Session</a></li>
                <li><a href="{{ route('counselors.index') }}">Counselors</a></li>
                @if (auth()->check())
                    <li><a href="{{ route('appointments.index') }}">My Appointments</a></li>
                @endif
            </ul>
        @elseif(auth('counselor')->check())
            <ul class="menu menu-horizontal px-1 hidden md:flex">
                <li><a href="{{ route('counselor.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('counselor.appointments.index') }}">My Appointments</a></li>
                <li><a href="{{ route('counselor.availability.index') }}">My Availability</a></li>
            </ul>
        @endif

        {{-- ✅ Avatar dropdown (kept for desktop + mobile) --}}
        @if(auth()->check())
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" />
                    </div>
                </label>
                <ul tabindex="0" class="mt-3 z-[60] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                    <li class="menu-title">{{ auth()->user()->name }}</li>
                    <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li>
                        <button type="submit" form="logout-form" class="w-full text-left">
                            Logout
                        </button>
                    </li>
                </ul>
            </div>

        @elseif(auth('counselor')->check())
            @php $counselor = auth('counselor')->user(); @endphp
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($counselor->name) }}&background=random" />
                    </div>
                </label>
                <ul tabindex="0" class="mt-3 z-[60] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-60">
                    <li class="menu-title">{{ $counselor->name }}</li>
                    <li>
                        <button type="submit" form="counselor-logout-form" class="w-full text-left">
                            Logout
                        </button>
                    </li>
                </ul>
            </div>
        @endif

    </div>
</nav>

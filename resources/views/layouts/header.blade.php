{{-- Top Navbar --}}
<nav class="navbar flex bg-base-100/70 backdrop-blur shadow-sm px-6 lg:px-12">
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

    <div class="flex gap-2">
        @if (!auth('counselor')->check())
            <ul class="menu menu-horizontal px-1 hidden md:flex">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('appointments.create') }}" data-requires-login>Book Session</a></li>
                <li><a href="{{ route('counselors.index') }}">Counselors</a></li>
                @if (auth()->check())
                    <li><a href="{{ route('appointments.index') }}">My Appointments</a></li>
                @endif
            </ul>
        @endif

        {{-- Logged-in USER (client) --}}
        @if(auth()->check())
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" />
                    </div>
                </label>
                <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                    <li class="menu-title">{{ auth()->user()->name }}</li>
                    <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li>
                        <button
                            type="submit"
                            form="logout-form"
                            class="w-full text-left"
                        >
                            Logout
                        </button>
                    </li>
                </ul>
            </div>

        {{-- Logged-in COUNSELOR --}}
        @elseif(auth('counselor')->check())
            @php $counselor = auth('counselor')->user(); @endphp

            <ul class="menu menu-horizontal px-1 hidden md:flex">
                <li><a href="{{ route('counselor.dashboard') }}"> Dashboard</a></li>
                <li><a href="{{ route('counselor.appointments.index') }}">My Appointments</a></li>
                <li><a href="{{ route('counselor.availability.index') }}">My Availability</a></li>
            </ul>

            <div class="dropdown dropdown-end z-50!">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($counselor->name) }}&background=random" />
                    </div>
                </label>
                <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-60">
                    <li class="menu-title">{{ $counselor->name }}</li>
                    <li>
                        <button
                            type="submit"
                            form="counselor-logout-form"
                            class="w-full text-left"
                            >
                                Logout
                        </button>
                    </li>
                </ul>

            </div>

        {{-- GUEST --}}

        @endif
    </div>
</nav>

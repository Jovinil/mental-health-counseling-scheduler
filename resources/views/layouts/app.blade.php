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
        @include('layouts.header')

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

    @auth
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
    @endauth

    @auth('counselor')
        <form id="counselor-logout-form" method="POST" action="{{ route('counselor.logout') }}" class="hidden">
            @csrf
        </form>
    @endauth

    @if (!auth()->check() && !auth('counselor')->check())
        {{-- Login prompt modal for guests trying to book --}}
        <dialog id="loginPromptModal" class="modal">
            <div class="modal-box relative">
                <button
                    type="button"
                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                    data-close-login-modal
                >&times;</button>

                <h3 class="font-bold text-lg mb-2">Please login to continue</h3>
                <p class="text-sm text-gray-600">
                    You need an account to book a counseling session. Choose how you want to sign in below.
                </p>

                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('user.login.authenticate') }}" class="btn btn-primary btn-sm">
                        Client Login
                    </a>
                    <a href="{{ route('counselor.login.authenticate') }}" class="btn btn-outline btn-sm">
                        Counselor Login
                    </a>
                </div>

                <div class="mt-4">
                    <button type="button" class="btn btn-ghost btn-sm" data-close-login-modal>
                        Not now
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    @endif

    <script>
        window.isAuthenticated = @json(auth()->check() || auth('counselor')->check());

        document.addEventListener('DOMContentLoaded', () => {
            if (window.isAuthenticated) return;

            const modal = document.getElementById('loginPromptModal');
            if (!modal) return;

            const closeModal = () => {
                if (typeof modal.close === 'function') {
                    modal.close();
                }
                modal.classList.remove('modal-open');
            };

            const openModal = () => {
                if (typeof modal.showModal === 'function') {
                    modal.showModal();
                } else {
                    modal.classList.add('modal-open');
                }
            };

            document.querySelectorAll('[data-close-login-modal]').forEach((el) => {
                el.addEventListener('click', (event) => {
                    event.preventDefault();
                    closeModal();
                });
            });

            document.querySelectorAll('[data-requires-login]').forEach((el) => {
                el.addEventListener('click', (event) => {
                    event.preventDefault();
                    openModal();
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>

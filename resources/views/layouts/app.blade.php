<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .dropdown:hover .dropdown-menu { display: block; }
        .min-h-screen-20 { min-height: calc(100vh - 5rem); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Navigation Bar -->
    <nav class="bg-red-700 shadow-md border-b-4 border-red-800" x-data="{ sidebarOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Left: Hamburger + Logo/App Name -->
                <div class="flex items-center">
                    @auth
                    <button @click="sidebarOpen = true" class="mr-4 text-yellow-400 hover:text-yellow-300 focus:outline-none text-2xl">
                        <i class="fas fa-bars"></i>
                    </button>
                    @endauth
                    <a href="{{ url('/') }}" class="text-xl font-bold text-yellow-400 hover:text-yellow-300 transition flex items-center">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        {{ config('app.name') }}
                    </a>
                </div>
                <!-- Auth Links -->
                <div class="flex items-center">
                    @auth
                        <!-- User Dropdown -->
                        <div class="ml-4 relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-yellow-100 hover:text-yellow-300 transition focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 @click.away="open = false"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="py-1">
                                    <a href="{{ route(auth()->user()->is_admin ? 'admin.dashboard' : 'user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-circle mr-2"></i> Dashboard
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="text-yellow-400 hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium transition">
                                <i class="fas fa-user-plus mr-1"></i> Register
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 bg-black bg-opacity-40 z-40" @click="sidebarOpen = false"></div>
        <!-- Sidebar -->
        <aside x-show="sidebarOpen" x-cloak class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50 transform transition-transform duration-200"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        >
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <span class="text-lg font-bold text-red-700">{{ config('app.name') }}</span>
                <button @click="sidebarOpen = false" class="text-red-700 hover:text-red-900 text-2xl focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mt-4">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-red-700 hover:bg-yellow-50 transition">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.users') }}" class="flex items-center px-6 py-3 text-red-700 hover:bg-yellow-50 transition">
                            <i class="fas fa-users mr-3"></i> Kelola Pengguna
                        </a>
                        <a href="{{ route('admin.transactions') }}" class="flex items-center px-6 py-3 text-red-700 hover:bg-yellow-50 transition">
                            <i class="fas fa-exchange-alt mr-3"></i> Transaksi
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="flex items-center px-6 py-3 text-red-700 hover:bg-yellow-50 transition">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                        <a href="{{ route('user.transactions') }}" class="flex items-center px-6 py-3 text-red-700 hover:bg-yellow-50 transition">
                            <i class="fas fa-history mr-3"></i> Transaksi Saya
                        </a>
                    @endif
                @endauth
            </nav>
        </aside>
    </nav>

    <!-- Page Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-red-700 shadow-md py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-yellow-100">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </footer>
    <!-- Optional: Place for additional scripts -->
    @stack('scripts')
</body>
</html>
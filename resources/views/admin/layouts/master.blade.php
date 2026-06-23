<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard' }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-xl font-bold">{{ config('app.name', 'Laravel') }}</h1>
                <p class="text-sm text-gray-400">Admin Dashboard</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                          {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                          {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Products</span>
                </a>

                <a href="{{ route('admin.transactions.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                          {{ request()->routeIs('admin.transactions.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Transactions</span>
                </a>
            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center gap-3 px-4 py-3">
                    <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-400">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $pageTitle ?? 'Dashboard' }}</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 bg-gray-100">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-4">
                <p class="text-sm text-gray-500 text-center">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Built with Laravel.
                </p>
            </footer>
        </div>
    </div>
</body>
</html>

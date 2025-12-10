<!DOCTYPE html>
<html lang="id">
<head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preload" as="image" href="/storage/background-sidebar.png">
    <link rel="icon" type="image/png" href="/storage/pln-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Feedback Inovasi PLN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar-bg {
            background: #17687a url('/storage/background-sidebar.png') center 90% / cover no-repeat;
            background-attachment: local;
            transition: background 0.2s;
            backface-visibility: hidden;
            transform: translateZ(0);
        }
        .sidebar-active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #06b6d4;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row min-h-screen w-full overflow-hidden">
        <!-- Sidebar (responsive) -->
        <aside class="w-full md:w-64 bg-gradient-to-b from-cyan-700 to-cyan-900 text-white lightning-bg flex-shrink-0 md:h-auto h-16 md:h-auto fixed md:static z-40 sidebar-bg transition-all duration-300" id="sidebar">
            <div class="flex md:flex-col flex-row items-center md:items-stretch justify-between md:justify-start p-4 md:p-6 h-full">

                <div class="flex items-center space-x-3 mb-8">
                    <svg class="w-8 h-8 md:w-10 md:h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="hidden md:block">
                        <h1 class="text-lg md:text-xl font-bold">Feedback</h1>
                        <p class="text-xs md:text-sm text-cyan-200">Inovasi PLN</p>
                    </div>
                    <!-- Titik tiga menu for mobile -->
                    <button class="md:hidden ml-auto" id="sidebarMenuBtn" aria-label="Buka menu">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="2" />
                            <circle cx="12" cy="6" r="2" />
                            <circle cx="12" cy="18" r="2" />
                        </svg>
                    </button>
                </div>

                <nav id="sidebarMenu" class="space-y-2 md:block hidden absolute top-16 right-2 left-2 bg-cyan-900 bg-opacity-95 rounded-xl shadow-xl p-4 z-50 md:static md:bg-transparent md:shadow-none md:p-0 md:rounded-none">
                    <script>
                    // Sidebar titik tiga responsive
                    document.addEventListener('DOMContentLoaded', function() {
                        var btn = document.getElementById('sidebarMenuBtn');
                        var menu = document.getElementById('sidebarMenu');
                        if (btn && menu) {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                menu.classList.toggle('hidden');
                            });
                            // Tutup menu jika klik di luar
                            document.addEventListener('click', function(e) {
                                if (!menu.classList.contains('hidden') && !menu.contains(e.target) && e.target !== btn) {
                                    menu.classList.add('hidden');
                                }
                            });
                        }
                    });
                    </script>
                    <a href="{{ route('admin.feedbacks') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.feedbacks') ? 'sidebar-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        <span>Feedback Response</span>
                    </a>

                    <a href="{{ route('admin.analytics') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.analytics') ? 'sidebar-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                            <span>Analytics</span>
                    </a>

                          <a href="{{ route('admin.input') }}" 
                              class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.input') ? 'sidebar-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Input Inovasi & Unit</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-md w-full">

                <div class="flex items-center justify-between px-8 py-4 w-full">
                    <!-- Inovasi Logo on the left -->
                    <div class="flex items-center space-x-4">
                        <img src="/storage/inovasi-logo.png" alt="Logo Inovasi" class="w-12 h-12 object-contain" />
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">Admin</span>
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center space-x-2">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
                </main>
            </div>

    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            if (!e.target.closest('button')) {
                document.getElementById('dropdown').classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

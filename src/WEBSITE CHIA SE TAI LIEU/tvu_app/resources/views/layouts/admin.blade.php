<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trang quản trị - TVU')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('static/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('static/css/compat.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/style.css') }}">
    
    <!-- Google Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script>
        // Initialize dark mode IMMEDIATELY
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    
    <script>
        // Configure Tailwind BEFORE loading
        tailwind = { config: { darkMode: 'class' } };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        // Additional Tailwind config after load
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#2563eb',
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        };
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <script>
        // Dark mode toggle function
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('darkMode', isDark ? 'dark' : 'light');
            
            // Update icon
            const icon = document.getElementById('darkModeIcon');
            if (icon) {
                icon.textContent = isDark ? 'light_mode' : 'dark_mode';
            }
            
            console.log('Dark mode:', isDark ? 'ON' : 'OFF');
        }
        
        // Update icon on page load
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            const icon = document.getElementById('darkModeIcon');
            if (icon) {
                icon.textContent = isDark ? 'light_mode' : 'dark_mode';
            }
        });
    </script>
</head>
<body class="min-h-screen bg-white dark:bg-gray-900">
    <!-- Header with Liquid Glass Effect -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/70 dark:bg-gray-900/70 border-b border-gray-200 dark:border-gray-700 rounded-b-3xl shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary" style="font-size: 32px;">menu_book</span>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">Trao Đổi Sách TVU</span>
                    </a>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-primary text-white">Admin</span>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all @if(request()->routeIs('admin.dashboard')) bg-primary text-white @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 @endif">
                        Bảng điều khiển
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all @if(request()->routeIs('admin.users.*')) bg-primary text-white @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 @endif">
                        Người dùng
                    </a>
                    <a href="{{ route('admin.documents.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all @if(request()->routeIs('admin.documents.*')) bg-primary text-white @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 @endif">
                        Tài liệu
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all @if(request()->routeIs('admin.orders.*')) bg-primary text-white @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 @endif">
                        Đơn hàng
                    </a>
                    <a href="{{ route('admin.blogs.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all @if(request()->routeIs('admin.blogs.*')) bg-primary text-white @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 @endif">
                        Blogs
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all @if(request()->routeIs('admin.categories.*')) bg-primary text-white @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 @endif">
                        Danh mục
                    </a>
                </nav>

                <!-- Right section -->
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        <span id="darkModeIcon" class="material-symbols-outlined text-gray-700 dark:text-gray-300" style="font-size: 24px;">dark_mode</span>
                    </button>
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-full text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        Về trang chủ
                    </a>
                    
                    <!-- User Menu -->
                    @auth
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center gap-2 px-3 py-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:block text-sm font-medium text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400" style="font-size: 20px;">arrow_drop_down</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-56 rounded-2xl shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 dark:ring-gray-700">
                            <div class="py-2">
                                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="material-symbols-outlined" style="font-size: 20px;">person</span>
                                    Hồ sơ
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <span class="material-symbols-outlined" style="font-size: 20px;">logout</span>
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen bg-white dark:bg-gray-900">
        <div class="w-full py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const button = event.target.closest('button[onclick="toggleUserMenu()"]');
            
            if (!button && userMenu && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

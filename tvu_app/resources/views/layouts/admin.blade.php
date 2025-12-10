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

    <script>window.tailwind = window.tailwind || {}; tailwind.config = { darkMode: 'class' };</script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <script>
        // Dark mode persistence (robust): helpers
        function __setTheme(mode){
            const html = document.documentElement;
            const body = document.body;
            // Always reset any lingering .dark classes except on <html>
            html.classList.remove('dark');
            if (body) body.classList.remove('dark');
            document.querySelectorAll('body .dark').forEach(el => el.classList.remove('dark'));
            // Apply only to <html> so Tailwind 'dark:' variants are consistent
            if (mode === 'dark') { html.classList.add('dark'); }
            html.setAttribute('data-theme', mode);
            localStorage.setItem('theme', mode);
            // Update toggle label & icon
            const textEl = document.getElementById('themeToggleText');
            const iconEl = document.getElementById('themeToggleIcon');
            if (textEl) textEl.textContent = mode === 'dark' ? 'Chuyển sang nền sáng' : 'Chuyển sang nền tối';
            if (iconEl) iconEl.setAttribute('data-feather', mode === 'dark' ? 'sun' : 'moon');
            if (window.feather) { window.feather.replace(); }
        }
        function __initTheme(){
            const saved = localStorage.getItem('theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            __setTheme(saved ? saved : (prefersDark ? 'dark' : 'light'));
        }
        function toggleTheme(){
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            const next = isDark ? 'light' : 'dark';
            __setTheme(next);
            // notify listeners (e.g., charts) to re-theme
            window.dispatchEvent(new CustomEvent('theme:changed', { detail: { mode: next } }));
            console.log('Theme toggled to', localStorage.getItem('theme'));
        }
        // Initialize ASAP
        document.addEventListener('DOMContentLoaded', __initTheme);
        // Sync across tabs
        window.addEventListener('storage', (e)=>{ if (e.key === 'theme' && e.newValue) __setTheme(e.newValue); });
    </script>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-950 border-r border-gray-200 dark:border-gray-800 hidden md:flex md:flex-col">
            <div class="h-16 flex items-center px-4 border-b border-gray-200 dark:border-gray-800">
                <div class="flex items-center gap-2 font-semibold">
                    <i data-feather="layers" class="text-indigo-600"></i>
                    <span>TVU Admin</span>
                </div>
            </div>
            <nav class="flex-1 p-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors hover:bg-indigo-600 hover:text-white dark:hover:text-white @if(request()->routeIs('admin.dashboard')) bg-indigo-100 dark:bg-gray-800 active-link @endif">
                    <i data-feather="grid"></i><span>Bảng điều khiển</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors hover:bg-indigo-600 hover:text-white dark:hover:text-white @if(request()->routeIs('admin.users.*')) bg-indigo-100 dark:bg-gray-800 active-link @endif">
                    <i data-feather="users"></i><span>Người dùng</span>
                </a>
                <a href="{{ route('admin.documents.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors hover:bg-indigo-600 hover:text-white dark:hover:text-white @if(request()->routeIs('admin.documents.*')) bg-indigo-100 dark:bg-gray-800 active-link @endif">
                    <i data-feather="file-text"></i><span>Tài liệu</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors hover:bg-indigo-600 hover:text-white dark:hover:text-white @if(request()->routeIs('admin.orders.*')) bg-indigo-100 dark:bg-gray-800 active-link @endif">
                    <i data-feather="shopping-cart"></i><span>Đơn hàng</span>
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors hover:bg-indigo-600 hover:text-white dark:hover:text-white @if(request()->routeIs('admin.blogs.*')) bg-indigo-100 dark:bg-gray-800 active-link @endif">
                    <i data-feather="book-open"></i><span>Blogs</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors hover:bg-indigo-600 hover:text-white dark:hover:text-white @if(request()->routeIs('admin.categories.*')) bg-indigo-100 dark:bg-gray-800 active-link @endif">
                    <i data-feather="layers"></i><span>Danh mục</span>
                </a>
            </nav>
            <div class="p-3 border-t border-gray-200 dark:border-gray-800 space-y-2">
                <button id="themeToggle" type="button" onclick="toggleTheme()" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i id="themeToggleIcon" data-feather="moon"></i><span id="themeToggleText">Chuyển chế độ</span>
                </button>
                <a href="{{ route('home') }}" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    <i data-feather="home"></i><span>Về trang chủ</span>
                </a>
            </div>
        </aside>

        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top bar (mobile) -->
            <div class="md:hidden sticky top-0 z-10 bg-white/80 dark:bg-gray-900/80 backdrop-blur border-b border-gray-200 dark:border-gray-800">
                <div class="h-14 flex items-center justify-between px-4">
                    <div class="flex items-center gap-2 font-semibold">
                        <i data-feather="grid"></i>
                        <span>TVU Admin</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="toggleTheme()" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800"><i data-feather="moon"></i></button>
                        <a href="{{ route('home') }}" class="p-2 rounded-lg bg-indigo-600 text-white"><i data-feather="home"></i></a>
                    </div>
                </div>
            </div>

            <main class="p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>if (window.feather) { window.feather.replace(); }</script>
    <style>
        /* Light-mode fallback to guarantee white look if any dark style leaks */
        html[data-theme="light"] body { background-color: #f9fafb !important; color: #111827 !important; }
        html[data-theme="light"] aside { background-color: #ffffff !important; }
        html[data-theme="light"] .admin-card { background-color: #ffffff !important; border-color: #e5e7eb !important; color: #111827 !important; }
        html[data-theme="light"] .admin-card h3, 
        html[data-theme="light"] .admin-card .text-gray-500 { color: #374151 !important; }
        /* Ensure sidebar active item + toggle look correct on light theme even if a stale .dark exists somewhere */
        html[data-theme="light"] aside a.active-link { background-color: #e0e7ff !important; color: #111827 !important; }
        html[data-theme="light"] #themeToggle { background-color: #f3f4f6 !important; color: #111827 !important; }
        /* Fix any dark table backgrounds in light mode */
        html[data-theme="light"] .admin-card table thead th { background-color: #f9fafb !important; color: #374151 !important; }
    html[data-theme="light"] .admin-card table tbody tr { background-color: #ffffff !important; color: #111827 !important; }
    html[data-theme="light"] .admin-card table td { color: #111827 !important; }
        html[data-theme="light"] .admin-card table tbody tr:hover { background-color: #eef2ff !important; }
        /* Make sure form controls are light in light mode */
        html[data-theme="light"] .admin-card input,
        html[data-theme="light"] .admin-card select,
        html[data-theme="light"] .admin-card textarea { background-color: #ffffff !important; color: #111827 !important; border-color: #e5e7eb !important; }
        /* Ensure headings are dark enough in light mode */
        html[data-theme="light"] .admin-card h1,
        html[data-theme="light"] .admin-card h2,
        html[data-theme="light"] .admin-card h3,
        html[data-theme="light"] .admin-card h4,
        html[data-theme="light"] .admin-card h5,
        html[data-theme="light"] .admin-card h6 { color: #111827 !important; }
    </style>
    @stack('scripts')
</body>
</html>

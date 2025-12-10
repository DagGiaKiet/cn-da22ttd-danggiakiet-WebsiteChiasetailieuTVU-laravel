<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TVU Book Exchange')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('static/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('static/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/compat.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>
<body class="bg-gray-50">
    @include('partials.landing_nav')

    <main class="py-6">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4">
                <div class="rounded-md bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4">
                <div class="rounded-md bg-red-50 p-4 text-red-700">{{ session('error') }}</div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4">
            @yield('content')
        </div>
    </main>

    @include('partials.landing_footer')

    <script>if (window.feather) { window.feather.replace(); }</script>
    @stack('scripts')
</body>
</html>

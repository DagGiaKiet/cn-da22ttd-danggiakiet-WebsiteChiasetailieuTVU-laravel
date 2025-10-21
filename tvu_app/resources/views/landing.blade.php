<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trao Đổi Sách TVU - Sinh viên Tra Vinh</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('static/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('static/css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="{{ asset('static/js/config.js') }}"></script>
    <script src="{{ asset('static/js/app.js') }}" defer></script>
</head>
<body class="bg-gray-50">
    
    @include('partials.landing_nav')
    @include('partials.landing_hero')
    @include('partials.landing_features')
    @include('partials.landing_popular')
    @include('partials.landing_cta')
    @include('partials.landing_footer')
</body>
</html>

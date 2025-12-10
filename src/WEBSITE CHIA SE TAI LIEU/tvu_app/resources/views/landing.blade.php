@extends('layouts.app')

@section('title', 'Trao Đổi Sách TVU - Sinh viên Tra Vinh')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Giữ nguyên nội dung gốc -->
        <div class="relative pt-12 pb-16 overflow-hidden">
            <div class="lg:text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                    <span class="block">Chia sẻ kiến thức,</span>
                    <span class="block text-primary">Xây dựng cộng đồng</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-400 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Nền tảng trao đổi sách và tài liệu học tập dành cho sinh viên Đại học Trà Vinh.
                </p>
                <div class="mt-6 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="{{ auth()->check() ? route('danh-muc') : route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-700 md:py-4 md:text-lg md:px-10">
                            Bắt đầu ngay
                        </a>
                    </div>
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                        <a href="{{ route('categories.learn-more') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                            Tìm hiểu thêm
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        @include('partials.landing_features')

        <!-- Popular Documents -->
        @include('partials.landing_popular')
    </div>
</div>

<!-- CTA Section - Full Width -->
@include('partials.landing_cta')
@endsection

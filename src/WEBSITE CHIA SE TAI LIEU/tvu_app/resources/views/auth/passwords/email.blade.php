@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-200px)] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Đặt lại mật khẩu
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Nhập email của bạn để nhận liên kết đặt lại mật khẩu
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-600 rounded-md p-4 text-sm" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Địa chỉ Email
                    </label>
                    <div class="mt-1">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Gửi liên kết đặt lại mật khẩu
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">
                            Hoặc
                        </span>
                    </div>
                </div>

                <div class="mt-6 text-center">
                     <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Quay lại đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

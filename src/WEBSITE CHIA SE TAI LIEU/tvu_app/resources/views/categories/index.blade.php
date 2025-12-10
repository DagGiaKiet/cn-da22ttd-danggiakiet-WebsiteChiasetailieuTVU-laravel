@extends('layouts.app')

@section('title', 'Danh mục - Trao Đổi Sách TVU')

@section('content')
<div class="w-full py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Danh mục tài liệu</h1>
      <p class="text-gray-600">Khám phá tài liệu theo khoa, ngành và môn học</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($khoas as $khoa)
        <a href="{{ route('categories.khoa', $khoa) }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border border-gray-200">
          <div class="flex items-center gap-3 mb-3">
            <div class="flex items-center justify-center size-12 rounded-lg bg-primary/10 text-primary">
              <span class="material-symbols-outlined" style="font-size: 28px;">school</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900">{{ $khoa->ten_khoa }}</h3>
          </div>
          <p class="text-gray-600 text-sm">{{ $khoa->nganhs->count() }} ngành học</p>
        </a>
      @empty
        <div class="col-span-full bg-white rounded-lg shadow p-6 text-center text-gray-500">
          Chưa có danh mục nào
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection

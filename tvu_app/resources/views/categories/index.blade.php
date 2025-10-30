@extends('layouts.app')

@section('content')
  {{-- Phần "Tìm hiểu thêm" từ giao diện tim-hieu-them.html --}}
  @include('categories.learn_more')

  {{-- Phần danh mục Khoa hiện có --}}
  <section class="py-12">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-blue-700 mb-6">Danh mục Khoa</h2>
        <ul class="list-disc pl-6 space-y-2">
          @foreach($khoas as $k)
            <li>
              <a class="text-blue-700 hover:text-blue-900" href="{{ route('categories.khoa', $k) }}">{{ $k->ten_khoa }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </section>
@endsection

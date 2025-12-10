@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
  @php
    $statusMap = [
      'pending' => ['text' => 'Chờ xử lý', 'class' => 'bg-gray-100 text-gray-800'],
      'dang_giao' => ['text' => 'Đang giao', 'class' => 'bg-yellow-100 text-yellow-800'],
      'da_nhan' => ['text' => 'Đã giao', 'class' => 'bg-green-100 text-green-800'],
      'huy' => ['text' => 'Đã hủy', 'class' => 'bg-red-100 text-red-800'],
    ];
    $st = $statusMap[$order->trang_thai] ?? ['text' => $order->trang_thai, 'class' => 'bg-gray-100 text-gray-800'];
    $doc = $order->document;
    $seller = optional($doc->user)->name ?? 'Người bán';
    $img = $doc->hinh_anh ? (Str::startsWith($doc->hinh_anh, ['http://','https://']) ? $doc->hinh_anh : asset('storage/'.$doc->hinh_anh)) : asset('img/maclenin.jpg');
    $price = number_format($doc->gia ?? 0, 0, ',', '.'). ' VND';
  @endphp

  <div class="py-12">
    <div class="bg-white shadow rounded-lg overflow-hidden">
      {{-- Header --}}
      <div class="border-b border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Đơn hàng #{{ $order->id }}</h1>
            <div class="mt-2 flex items-center">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $st['class'] }}">{{ $st['text'] }}</span>
              <p class="ml-2 text-sm text-gray-500">Ngày đặt: {{ optional($order->created_at)->format('d/m/Y') }}</p>
            </div>
          </div>
          <div class="mt-4 md:mt-0">
            <p class="text-xl font-bold text-primary">{{ $price }}</p>
          </div>
        </div>
      </div>

      {{-- Items --}}
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Tài liệu đã đặt</h2>
        <div class="border border-gray-200 rounded-lg overflow-hidden">
          <div class="p-4 flex flex-col md:flex-row items-start md:items-center gap-4">
            <img src="{{ $img }}" alt="{{ $doc->ten_tai_lieu }}" class="w-20 h-20 object-cover rounded">
            <div class="flex-1">
              <h3 class="text-lg font-medium text-gray-900">{{ $doc->ten_tai_lieu }}</h3>
              <p class="text-gray-600 mt-1">{{ $doc->mo_ta }}</p>
              <p class="text-sm text-gray-500 mt-1">Đăng bởi: {{ $seller }}</p>
            </div>
            <div class="flex flex-col items-end">
              <span class="font-bold">{{ $price }}</span>
              <span class="text-sm text-gray-500">Số lượng: 1</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Summary --}}
      <div class="p-6 bg-gray-50">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Thông tin đơn hàng</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <h3 class="text-md font-medium text-gray-900 mb-2">Thông tin nhận hàng</h3>
            <div class="bg-white p-4 rounded-lg border border-gray-200">
              <p class="font-medium">{{ auth()->user()->name ?? '—' }}</p>
              <p class="text-gray-600 mt-1">Email: {{ auth()->user()->email ?? '—' }}</p>
              @php $phone = auth()->user()->phone ?? null; @endphp
              <p class="text-gray-600">SĐT: {{ $phone ?? '—' }}</p>
              <p class="text-gray-600 mt-2">Nhận tại: Thư viện TVU</p>
            </div>
          </div>
          <div>
            <h3 class="text-md font-medium text-gray-900 mb-2">Tổng kết đơn hàng</h3>
            <div class="bg-white p-4 rounded-lg border border-gray-200">
              <div class="flex justify-between py-2 border-b border-gray-200">
                <span class="text-gray-600">Tạm tính</span>
                <span class="font-medium">{{ $price }}</span>
              </div>
              <div class="flex justify-between py-2 border-b border-gray-200">
                <span class="text-gray-600">Phí vận chuyển</span>
                <span class="font-medium">0 VND</span>
              </div>
              <div class="flex justify-between py-2">
                <span class="text-lg font-bold text-gray-900">Tổng cộng</span>
                <span class="text-lg font-bold text-primary">{{ $price }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Actions --}}
      <div class="p-6 border-t border-gray-200 bg-gray-50">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div>
            <h3 class="text-md font-medium text-gray-900">Hỗ trợ đơn hàng</h3>
            <p class="text-sm text-gray-500 mt-1">Cần hỗ trợ? Liên hệ với người bán hoặc bộ phận hỗ trợ của chúng tôi</p>
          </div>
          <div class="flex space-x-2">
            <a href="{{ route('orders.index') }}" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">
              <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> Quay lại đơn hàng
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

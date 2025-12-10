@extends('layouts.app')
@section('title','Giỏ hàng - Trao Đổi Sách TVU')
@section('content')
<div class="w-full py-4">
  <div class="flex flex-col lg:flex-row gap-8">
    <!-- Cart Items -->
    <div class="lg:w-2/3">
      <h1 class="text-2xl font-bold text-gray-900 mb-6">Giỏ hàng của bạn</h1>
      <div class="bg-white shadow rounded-lg overflow-hidden">
        @php $itemsCol = \Illuminate\Support\Collection::make($items); @endphp
        @if($itemsCol->isEmpty())
          <div id="emptyCart" class="p-8 text-center">
            <i data-feather="shopping-cart" class="mx-auto h-12 w-12 text-gray-400"></i>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Giỏ hàng trống</h3>
            <p class="mt-1 text-gray-500">Hãy thêm tài liệu vào giỏ hàng để bắt đầu mua sắm.</p>
            <div class="mt-6">
              <a href="{{ route('danh-muc') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-700">
                <i data-feather="book" class="mr-2 w-4 h-4"></i> Xem danh mục tài liệu
              </a>
            </div>
          </div>
        @else
          <div id="cartItems" class="divide-y divide-gray-200">
            @foreach($itemsCol as $item)
              <div class="cart-item p-4 flex flex-col sm:flex-row items-start sm:items-center gap-4" data-item-id="{{ $item->id }}">
                @php
                  $doc = $item->document;
                  $img = $doc->hinh_anh ? asset('storage/'.$doc->hinh_anh) : asset('img/maclenin.jpg');
                @endphp
                <img src="{{ $img }}" alt="{{ $doc->ten_tai_lieu }}" class="w-20 h-20 object-cover rounded">
                <div class="flex-1">
                  <h3 class="text-lg font-medium text-gray-900">{{ $doc->ten_tai_lieu }}</h3>
                  <p class="text-gray-600 mt-1">{{ Str::limit($doc->mo_ta, 120) }}</p>
                </div>
                <div class="flex items-center gap-4">
                  <span class="font-bold">{{ $doc->loai === 'cho' ? 'Miễn phí' : number_format($doc->gia, 0, ',', '.') . ' VND' }}</span>
                  <button type="button" class="remove-item-btn flex items-center justify-center size-9 rounded-full hover:bg-red-50 text-red-500 hover:text-red-700 transition-colors" title="Xóa khỏi giỏ" data-url="{{ route('cart.remove', $item) }}">
                    <span class="material-symbols-outlined" style="font-size: 20px;">delete</span>
                  </button>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    <!-- Order Summary -->
    <div class="lg:w-1/3">
      <div class="bg-white shadow rounded-lg p-6 sticky top-4">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Tổng kết đơn hàng</h2>
        @if($itemsCol->isNotEmpty())
        @php
          $subtotal = $itemsCol->sum(function($i){ return $i->document->loai === 'cho' ? 0 : (float)$i->document->gia; });
        @endphp
        <div id="orderSummary">
          <div class="space-y-4">
            <div class="flex justify-between">
              <span class="text-gray-600">Tạm tính</span>
              <span id="subtotal" class="font-medium">{{ number_format($subtotal, 0, ',', '.') }} VND</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Phí vận chuyển</span>
              <span class="font-medium">0 VND</span>
            </div>
            <div class="border-t border-gray-200 pt-4 flex justify-between">
              <span class="text-lg font-bold text-gray-900">Tổng cộng</span>
              <span id="total" class="text-lg font-bold text-primary">{{ number_format($subtotal, 0, ',', '.') }} VND</span>
            </div>
          </div>
          <form method="POST" action="{{ route('cart.checkout') }}" class="mt-6">@csrf
            <button class="w-full bg-primary border border-transparent rounded-md py-3 px-4 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Đặt hàng</button>
          </form>
        </div>
        @else
          <div class="text-gray-600">Chưa có gì để thanh toán.</div>
        @endif

        @auth
        @php
          $orders = auth()->user()->orders()->latest()->take(5)->get();
        @endphp
        @if($orders->isNotEmpty())
          <div id="orderHistory" class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Lịch sử đơn hàng</h2>
            <div class="space-y-4">
              @foreach($orders as $o)
                <div class="border border-gray-200 rounded-lg p-4">
                  <div class="flex justify-between">
                    <span class="font-medium">Đơn hàng #{{ $o->id }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $o->trang_thai === 'dang_giao' ? 'bg-yellow-100 text-yellow-800' : ($o->trang_thai === 'da_nhan' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                      {{ $o->trang_thai }}
                    </span>
                  </div>
                  <p class="text-sm text-gray-500 mt-1">Ngày đặt: {{ $o->created_at->format('d/m/Y') }}</p>
                  <p class="text-sm text-gray-500">Tài liệu: {{ $o->document->ten_tai_lieu }}</p>
                </div>
              @endforeach
            </div>
          </div>
        @endif
        @endauth
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const cartBadge = document.querySelector('#cartBadge');
  
  document.querySelectorAll('.remove-item-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const itemDiv = this.closest('.cart-item');
      const itemId = itemDiv.dataset.itemId;
      const url = this.dataset.url;
      
      if (!confirm('Bạn có chắc muốn xóa tài liệu này khỏi giỏ hàng?')) return;
      
      fetch(url, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Remove item from UI
          itemDiv.remove();
          
          // Update cart badge
          if (cartBadge) {
            const currentCount = parseInt(cartBadge.textContent);
            const newCount = currentCount - 1;
            if (newCount > 0) {
              cartBadge.textContent = newCount;
            } else {
              cartBadge.remove();
            }
          }
          
          // Check if cart is empty
          const cartItems = document.getElementById('cartItems');
          if (cartItems.children.length === 0) {
            cartItems.innerHTML = '<div class="p-8 text-center text-gray-500">Giỏ hàng trống</div>';
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại.');
      });
    });
  });
});
</script>
@endpush

@endsection

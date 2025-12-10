@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
  <div class="py-12">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Lịch sử đơn hàng</h1>

    {{-- Tabs trạng thái --}}
    @php
      $status = request('status');
      $tabs = [
        '' => 'Tất cả',
        'pending' => 'Chờ xử lý',
        'dang_giao' => 'Đang giao',
        'da_nhan' => 'Đã giao',
        'huy' => 'Đã hủy',
      ];
    @endphp
    <div class="border-b border-gray-200 mb-6">
      <nav class="-mb-px flex space-x-8">
        @foreach($tabs as $key => $label)
          <a href="{{ route('orders.index', array_filter(['status'=>$key])) }}"
             class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ ($status===$key || ($key==='' && empty($status))) ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            {{ $label }}
          </a>
        @endforeach
      </nav>
    </div>

    {{-- Danh sách đơn hàng --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
      @forelse($orders as $o)
        @php
          $labelClass = match($o->trang_thai){
            'dang_giao' => 'bg-yellow-100 text-yellow-800',
            'da_nhan' => 'bg-green-100 text-green-800',
            'huy' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
          };
          $labelText = match($o->trang_thai){
            'pending' => 'Chờ xử lý',
            'dang_giao' => 'Đang giao',
            'da_nhan' => 'Đã giao',
            'huy' => 'Đã hủy',
            default => $o->trang_thai,
          };
          $price = number_format($o->document->gia ?? 0, 0, ',', '.') . ' VND';
        @endphp
        <div class="border-b border-gray-200 p-6">
          <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div class="mb-4 md:mb-0">
              <div class="flex items-center">
                <h3 class="text-lg font-medium text-gray-900">Đơn hàng #{{ $o->id }}</h3>
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $labelClass }}">{{ $labelText }}</span>
              </div>
              <p class="text-sm text-gray-500 mt-1">Ngày đặt: {{ optional($o->created_at)->format('d/m/Y') }}</p>
              <p class="text-sm text-gray-500">Sản phẩm: {{ $o->document->ten_tai_lieu }}</p>
            </div>
            <div class="flex flex-col items-end">
              <p class="text-lg font-bold text-gray-900">{{ $price }}</p>
              <div class="mt-2 flex space-x-2">
                <a href="{{ route('orders.show', $o) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                  <i data-feather="eye" class="w-4 h-4 mr-1"></i> Xem chi tiết
                </a>
                @if($o->trang_thai==='pending')
                  <button type="button" data-cancel-url="{{ route('orders.cancel', $o) }}" class="open-cancel inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Hủy đơn
                  </button>
                @endif
                @if($o->trang_thai==='dang_giao')
                  <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">Liên hệ người bán</button>
                @elseif($o->trang_thai==='da_nhan')
                  <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">Đánh giá</button>
                @endif
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="p-8 text-center text-gray-500">Bạn chưa có đơn hàng nào.</div>
      @endforelse
    </div>

    <div class="mt-4">{{ $orders->withQueryString()->links() }}</div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const modal = document.getElementById('cancelModal');
  const backdrop = document.getElementById('cancelBackdrop');
  const form = document.getElementById('cancelForm');
  function open(url){
    form.action = url;
    modal.classList.remove('hidden');
    requestAnimationFrame(()=>{
      backdrop.classList.remove('opacity-0'); backdrop.classList.add('opacity-100');
    });
  }
  function close(){
    backdrop.classList.add('opacity-0'); backdrop.classList.remove('opacity-100');
    setTimeout(()=>modal.classList.add('hidden'),150);
  }
  document.querySelectorAll('.open-cancel').forEach(btn=>{
    btn.addEventListener('click', ()=> open(btn.dataset.cancelUrl));
  });
  document.querySelectorAll('[data-close-cancel]').forEach(b=> b.addEventListener('click', close));
  if (backdrop) backdrop.addEventListener('click', close);
});
</script>
@endpush

{{-- Cancel confirmation modal --}}
<div id="cancelModal" class="hidden fixed inset-0 z-50">
  <div id="cancelBackdrop" class="absolute inset-0 bg-black/40 transition-opacity opacity-0"></div>
  <div class="relative z-10 max-w-md mx-auto mt-[20vh]">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden">
      <div class="px-5 py-4 border-b">
        <h3 class="text-base font-semibold text-gray-900">Xác nhận hủy đơn</h3>
      </div>
      <form id="cancelForm" method="POST" action="#">
        @csrf
        <div class="px-5 py-4 text-sm text-gray-700">
          Bạn có chắc chắn muốn hủy đơn hàng này? Hành động này không thể hoàn tác.
        </div>
        <div class="px-5 py-3 border-t flex items-center justify-end gap-2 bg-gray-50">
          <button type="button" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-white" data-close-cancel>Không</button>
          <button type="submit" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">Hủy đơn</button>
        </div>
      </form>
    </div>
  </div>
</div>

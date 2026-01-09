@extends('layouts.app')

@section('title', $document->ten_tai_lieu)

@section('content')
  @php
    $imgPath = $document->hinh_anh;
    $imgUrl = $imgPath
      ? (\Illuminate\Support\Str::startsWith($imgPath, ['http://','https://','img/']) ? (\Illuminate\Support\Str::startsWith($imgPath, 'img/') ? asset($imgPath) : $imgPath) : asset('storage/'.$imgPath))
      : asset('img/maclenin.jpg');
    $isFree = $document->loai === 'cho';
    $priceText = $isFree ? 'Miễn phí' : number_format($document->gia ?? 0, 0, ',', '.').' VND';
  @endphp

  <div class="py-8">
    <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Left: Cover image --}}
        <div class="lg:col-span-5">
          <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
            <img src="{{ $imgUrl }}" alt="{{ $document->ten_tai_lieu }}" class="w-full h-auto object-cover">
          </div>
        </div>

        {{-- Right: Info --}}
        <div class="lg:col-span-7">
          <div class="bg-white rounded-xl shadow border border-gray-100 p-6 relative">
             <div class="absolute top-6 right-6">
                <button onclick="history.back()" class="p-2 rounded-full bg-white font-medium text-gray-700 hover:text-primary hover:bg-gray-100 shadow-sm border border-gray-200 transition-colors flex items-center justify-center" title="Quay lại">
                    <span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
                </button>
             </div>
            <div class="flex items-start justify-between pr-14">
              <h1 class="text-2xl font-bold text-gray-900 pr-4">{{ $document->ten_tai_lieu }}</h1>
              <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $isFree ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">{{ $isFree ? 'Miễn phí' : 'Bán lại' }}</span>
            </div>
            <p class="mt-2 text-gray-600">{{ $document->mo_ta }}</p>

            <div class="mt-4 flex items-center justify-between">
              <div>
                <div class="text-2xl font-extrabold text-gray-900">{{ $priceText }}</div>
                <div class="mt-1 text-sm text-gray-500">Đăng bởi: <span class="font-medium text-gray-700">{{ optional($document->user)->name ?? '—' }}</span> · {{ optional($document->created_at)->format('d/m/Y') }}</div>
              </div>
              <div class="flex items-center space-x-2">
                {{-- Save/Unsave --}}
                @auth
                  <form method="POST" action="{{ route('documents.save', $document) }}">
                    @csrf
                    <button class="inline-flex items-center px-4 py-2 rounded-md border {{ ($saved ?? false) ? 'border-yellow-400 text-yellow-700 bg-yellow-50' : 'border-gray-300 text-gray-700 bg-white' }} hover:bg-gray-50">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                      {{ ($saved ?? false) ? 'Bỏ lưu' : 'Lưu' }}
                    </button>
                  </form>
                @endauth
              </div>
            </div>

            <div class="mt-6 flex items-center space-x-3">
              @if($document->trang_thai === 'available')
                  <form method="POST" action="{{ route('cart.add', $document) }}">
                    @csrf
                    <button class="inline-flex items-center px-5 py-2.5 rounded-md text-white bg-primary hover:bg-primary-700 font-medium">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m12-9l2 9M7 22a1 1 0 100-2 1 1 0 000 2zm12 0a1 1 0 100-2 1 1 0 000 2z"/></svg>
                      Thêm vào giỏ
                    </button>
                  </form>
              @else
                  <button disabled class="inline-flex items-center px-5 py-2.5 rounded-md text-white bg-gray-400 cursor-not-allowed font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    Hết hàng
                  </button>
              @endif

              @can('update', $document)
                <a href="{{ route('documents.edit', $document) }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50">Sửa</a>
              @endcan
            </div>

            {{-- Meta --}}
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="p-4 rounded-lg bg-gray-50">
                <div class="text-sm text-gray-500">Khoa</div>
                <div class="font-medium text-gray-900">{{ optional($document->khoa)->ten_khoa ?? '—' }}</div>
              </div>
              <div class="p-4 rounded-lg bg-gray-50">
                <div class="text-sm text-gray-500">Ngành</div>
                <div class="font-medium text-gray-900">{{ optional($document->nganh)->ten_nganh ?? '—' }}</div>
              </div>
              <div class="p-4 rounded-lg bg-gray-50">
                <div class="text-sm text-gray-500">Môn học</div>
                <div class="font-medium text-gray-900">{{ optional($document->mon)->ten_mon ?? '—' }}</div>
              </div>
              <div class="p-4 rounded-lg bg-gray-50">
                <div class="text-sm text-gray-500">Tình trạng</div>
                <div class="font-medium text-gray-900">{{ $document->trang_thai === 'available' ? 'Còn hàng' : 'Đã bán' }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Description full --}}
      @if(!empty($document->mo_ta))
      <div class="mt-8 bg-white rounded-xl shadow border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900">Mô tả chi tiết</h2>
        <p class="mt-2 text-gray-700 leading-relaxed">{{ $document->mo_ta }}</p>
      </div>
      @endif

      {{-- Related documents --}}
      @if(isset($related) && $related->count())
      <div class="mt-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Tài liệu liên quan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach($related as $d)
            @php
              $p = $d->hinh_anh;
              $img = $p ? (\Illuminate\Support\Str::startsWith($p, ['http://','https://','img/']) ? (\Illuminate\Support\Str::startsWith($p, 'img/') ? asset($p) : $p) : asset('storage/'.$p)) : asset('img/maclenin.jpg');
              $free = $d->loai === 'cho';
              $price = $free ? 'Miễn phí' : number_format($d->gia ?? 0, 0, ',', '.').' VND';
            @endphp
            <a href="{{ route('documents.show', $d) }}" class="group block bg-white rounded-xl border border-gray-100 shadow hover:shadow-md transition overflow-hidden">
              <div class="aspect-[16/9] bg-gray-100">
                <img src="{{ $img }}" alt="{{ $d->ten_tai_lieu }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform" />
              </div>
              <div class="p-4">
                <h3 class="text-base font-semibold text-gray-900 line-clamp-2">{{ $d->ten_tai_lieu }}</h3>
                <div class="mt-2 flex items-center justify-between">
                  <span class="inline-flex items-center px-2 py-0.5 text-xs rounded-full {{ $free ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">{{ $free ? 'Miễn phí' : 'Bán lại' }}</span>
                  <span class="text-sm font-bold text-gray-900">{{ $price }}</span>
                </div>
              </div>
            </a>
          @endforeach
        </div>
      </div>
      @endif
    </div>
  </div>
@endsection

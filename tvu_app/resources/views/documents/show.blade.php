@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-4">
      @php
        $imgPath = $document->hinh_anh;
        $imgUrl = $imgPath
          ? (\Illuminate\Support\Str::startsWith($imgPath, 'img/') ? asset($imgPath) : asset('storage/'.$imgPath))
          : null;
      @endphp
      @if($imgUrl)
        <img class="img-fluid" src="{{ $imgUrl }}" alt="{{ $document->ten_tai_lieu }}"/>
      @endif
    </div>
    <div class="col-md-8">
      <h3>{{ $document->ten_tai_lieu }}</h3>
      <p>{{ $document->mo_ta }}</p>
      <p><strong>{{ $document->loai === 'cho' ? 'Miễn phí' : number_format($document->gia).' đ' }}</strong></p>
      <form method="POST" action="{{ route('cart.add', $document) }}">
        @csrf
        <button class="btn btn-success">Thêm vào giỏ</button>
      </form>
      @auth
      <form method="POST" action="{{ route('documents.save', $document) }}" class="d-inline-block ms-2">
        @csrf
        <button class="btn btn-outline-secondary">{{ ($saved ?? false) ? 'Bỏ lưu' : 'Lưu' }}</button>
      </form>
      @endauth
    </div>
  </div>
</div>
@endsection

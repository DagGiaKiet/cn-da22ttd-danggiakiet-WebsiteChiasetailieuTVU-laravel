@extends('layouts.app')
@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Tài liệu</h3>
    <a class="btn btn-success" href="{{ route('documents.create') }}">Đăng tài liệu</a>
  </div>
  <div class="row">
    @foreach($documents as $doc)
      <div class="col-md-3 mb-3">
        <div class="card h-100 d-flex flex-column">
          @php
            $imgPath = $doc->hinh_anh;
            $imgUrl = $imgPath
              ? (\Illuminate\Support\Str::startsWith($imgPath, 'img/') ? asset($imgPath) : asset('storage/'.$imgPath))
              : asset('img/maclenin.jpg');
          @endphp
          <img class="card-img-top" src="{{ $imgUrl }}" alt="{{ $doc->ten_tai_lieu }}" style="height: 180px; object-fit: cover;"/>
          <div class="card-body flex-grow-1">
            <h6>{{ $doc->ten_tai_lieu }}</h6>
            <p class="mb-1"><small>{{ $doc->khoa->ten_khoa }} • {{ $doc->nganh->ten_nganh }} • {{ $doc->mon->ten_mon }}</small></p>
            <strong>{{ $doc->loai === 'cho' ? 'Miễn phí' : number_format($doc->gia).' đ' }}</strong>
          </div>
          <div class="card-footer mt-auto text-end">
            <a href="{{ route('documents.show',$doc) }}" class="btn btn-primary btn-sm">Xem</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  {{ $documents->links() }}
  </div>
@endsection

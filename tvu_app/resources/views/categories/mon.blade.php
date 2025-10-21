@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Môn: {{ $mon->ten_mon }}</h3>
  <div class="row">
    @foreach($documents as $doc)
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          @if($doc->hinh_anh)
            <img class="card-img-top" src="{{ asset('storage/'.$doc->hinh_anh) }}" alt="{{ $doc->ten_tai_lieu }}"/>
          @endif
          <div class="card-body">
            <h5 class="card-title">{{ $doc->ten_tai_lieu }}</h5>
            <p class="card-text">{{ \Illuminate\Support\Str::limit($doc->mo_ta, 100) }}</p>
            <p class="card-text"><strong>{{ $doc->loai === 'cho' ? 'Miễn phí' : number_format($doc->gia) . ' đ' }}</strong></p>
            <a href="{{ route('documents.show', $doc) }}" class="btn btn-primary btn-sm">Xem</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  {{ $documents->links() }}
  <a href="{{ route('categories.nganh', $mon->nganh) }}">« Quay lại</a>
</div>
@endsection

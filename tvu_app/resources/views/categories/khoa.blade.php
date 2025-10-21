@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Khoa: {{ $khoa->ten_khoa }}</h3>
  <ul>
    @foreach($nganhs as $n)
      <li><a href="{{ route('categories.nganh', $n) }}">{{ $n->ten_nganh }}</a></li>
    @endforeach
  </ul>
  <a href="{{ route('categories.index') }}">« Quay lại</a>
</div>
@endsection

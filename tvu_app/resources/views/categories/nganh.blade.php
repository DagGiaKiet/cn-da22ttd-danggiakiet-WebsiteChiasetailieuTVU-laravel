@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Ngành: {{ $nganh->ten_nganh }}</h3>
  <ul>
    @foreach($mons as $m)
      <li><a href="{{ route('categories.mon', $m) }}">{{ $m->ten_mon }}</a></li>
    @endforeach
  </ul>
  <a href="{{ route('categories.khoa', $nganh->khoa) }}">« Quay lại</a>
</div>
@endsection

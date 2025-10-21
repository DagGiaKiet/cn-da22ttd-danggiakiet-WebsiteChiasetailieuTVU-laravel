@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Chọn Khoa</h3>
  <ul>
    @foreach($khoas as $k)
      <li><a href="{{ route('categories.khoa', $k) }}">{{ $k->ten_khoa }}</a></li>
    @endforeach
  </ul>
</div>
@endsection

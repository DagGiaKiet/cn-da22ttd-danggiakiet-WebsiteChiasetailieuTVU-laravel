@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Đơn hàng #{{ $order->id }}</h3>
  <p>Tài liệu: {{ $order->document->ten_tai_lieu }}</p>
  <p>Trạng thái: {{ $order->trang_thai }}</p>
  <a href="{{ route('orders.index') }}">« Danh sách đơn</a>
</div>
@endsection

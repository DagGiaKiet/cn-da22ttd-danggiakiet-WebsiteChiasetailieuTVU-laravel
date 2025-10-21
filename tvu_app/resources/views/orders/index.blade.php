@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Đơn hàng</h3>
  <table class="table">
    <thead><tr><th>#</th><th>Tài liệu</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
    @foreach($orders as $o)
      <tr>
        <td>{{ $o->id }}</td>
        <td>{{ $o->document->ten_tai_lieu }}</td>
        <td>{{ $o->trang_thai }}</td>
        <td><a class="btn btn-sm btn-outline-primary" href="{{ route('orders.show', $o) }}">Xem</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $orders->links() }}
</div>
@endsection

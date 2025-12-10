@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Khoas</h3>
  <form method="POST" action="{{ route('admin.khoas.store') }}">@csrf
    <div class="input-group mb-2"><input name="ten_khoa" class="form-control" placeholder="Tên khoa"><button class="btn btn-primary">Thêm</button></div>
  </form>
  <ul>
    @foreach($khoas as $k)
      <li>{{ $k->ten_khoa }}</li>
    @endforeach
  </ul>
  {{ $khoas->links() }}
</div>
@endsection

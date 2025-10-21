@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Quản lý danh mục</h3>
  <div class="row">
    <div class="col-md-4">
      <h5>Khoa</h5>
      <form method="POST" action="{{ route('admin.khoas.store') }}">@csrf
        <div class="input-group mb-2"><input name="ten_khoa" class="form-control" placeholder="Tên khoa"><button class="btn btn-primary">Thêm</button></div>
      </form>
      <ul>
        @foreach($khoas as $k)
          <li>{{ $k->ten_khoa }}</li>
        @endforeach
      </ul>
    </div>
    <div class="col-md-4">
      <h5>Ngành</h5>
      <form method="POST" action="{{ route('admin.nganhs.store') }}">@csrf
        <div class="mb-2"><select name="khoa_id" class="form-select">
          @foreach($khoas as $k)
            <option value="{{ $k->id }}">{{ $k->ten_khoa }}</option>
          @endforeach
        </select></div>
        <div class="input-group mb-2"><input name="ten_nganh" class="form-control" placeholder="Tên ngành"><button class="btn btn-primary">Thêm</button></div>
      </form>
      <ul>
        @foreach($nganhs as $n)
          <li>{{ $n->ten_nganh }} ({{ $n->khoa->ten_khoa }})</li>
        @endforeach
      </ul>
    </div>
    <div class="col-md-4">
      <h5>Môn</h5>
      <form method="POST" action="{{ route('admin.mons.store') }}">@csrf
        <div class="mb-2"><select name="nganh_id" class="form-select">
          @foreach($nganhs as $n)
            <option value="{{ $n->id }}">{{ $n->ten_nganh }}</option>
          @endforeach
        </select></div>
        <div class="input-group mb-2"><input name="ten_mon" class="form-control" placeholder="Tên môn"><button class="btn btn-primary">Thêm</button></div>
      </form>
      <ul>
        @foreach($mons as $m)
          <li>{{ $m->ten_mon }} ({{ $m->nganh->ten_nganh }} - {{ $m->nganh->khoa->ten_khoa }})</li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Ngànhs</h3>
  <form method="POST" action="{{ route('admin.nganhs.store') }}">@csrf
    <div class="mb-2"><select name="khoa_id" class="form-select">
      @foreach(\App\Models\Khoa::all() as $k)
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
  {{ $nganhs->links() }}
</div>
@endsection

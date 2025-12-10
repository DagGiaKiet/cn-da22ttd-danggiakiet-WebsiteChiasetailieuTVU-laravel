@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Môn học</h3>
  <form method="POST" action="{{ route('admin.mons.store') }}">@csrf
    <div class="mb-2"><select name="nganh_id" class="form-select">
      @foreach(\App\Models\Nganh::with('khoa')->get() as $n)
        <option value="{{ $n->id }}">{{ $n->ten_nganh }} ({{ $n->khoa->ten_khoa }})</option>
      @endforeach
    </select></div>
    <div class="input-group mb-2"><input name="ten_mon" class="form-control" placeholder="Tên môn"><button class="btn btn-primary">Thêm</button></div>
  </form>
  <ul>
    @foreach($mons as $m)
      <li>{{ $m->ten_mon }} ({{ $m->nganh->ten_nganh }} - {{ $m->nganh->khoa->ten_khoa }})</li>
    @endforeach
  </ul>
  {{ $mons->links() }}
</div>
@endsection

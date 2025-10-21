@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Quản lý blog</h3>
  <table class="table"><thead><tr><th>#</th><th>Tiêu đề</th><th>Tác giả</th></tr></thead>
  <tbody>
  @foreach($blogs as $b)
    <tr><td>{{ $b->id }}</td><td>{{ $b->tieu_de }}</td><td>{{ $b->user->name }}</td></tr>
  @endforeach
  </tbody></table>
  {{ $blogs->links() }}
</div>
@endsection

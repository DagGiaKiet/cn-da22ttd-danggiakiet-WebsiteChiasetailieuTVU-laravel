@extends('layouts.admin')
@section('title','Admin - Quản lý tài liệu')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-semibold text-gray-900">Quản lý tài liệu</h2>
      <p class="mt-1 text-sm text-gray-500">Kiểm duyệt tài liệu được đăng tải</p>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên tài liệu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người đăng</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($documents as $d)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $d->ten_tai_lieu }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->user->name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->loai }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->loai==='cho' ? 'Miễn phí' : number_format($d->gia, 0, ',', '.') . ' VND' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $d->trang_thai === 'available' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $d->trang_thai }}</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="mt-4">{{ $documents->links() }}</div>
    </div>
  </div>
</div>
@endsection

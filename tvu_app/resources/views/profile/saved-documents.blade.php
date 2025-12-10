@extends('layouts.app')
@section('title','Tài liệu đã lưu')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold text-gray-900">Tài liệu đã lưu</h2>
        <p class="mt-1 text-sm text-gray-500">Danh sách tài liệu bạn đã đánh dấu lưu</p>
      </div>
      <a href="{{ route('profile.index') }}" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Quay lại hồ sơ</a>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên tài liệu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người đăng</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khoa</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngành</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($saved as $d)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600"><a href="{{ route('documents.show', $d) }}">{{ $d->ten_tai_lieu }}</a></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($d->user)->name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($d->khoa)->ten_khoa }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($d->nganh)->ten_nganh }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-4 text-sm text-gray-500">Bạn chưa lưu tài liệu nào.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-4">{{ $saved->links() }}</div>
    </div>
  </div>
</div>
@endsection

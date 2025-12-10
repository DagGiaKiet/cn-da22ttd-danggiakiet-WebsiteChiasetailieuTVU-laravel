@extends('layouts.app')
@section('title','Bài viết đã lưu')
@section('content')
<div class="w-full py-4 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
  <div class="bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold text-gray-900">Bài viết đã lưu</h2>
        <p class="mt-1 text-sm text-gray-500">Danh sách bài viết bạn đã đánh dấu lưu</p>
      </div>
      <a href="{{ route('profile.index') }}" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Quay lại hồ sơ</a>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tác giả</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày đăng</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($saved as $b)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $b->id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600"><a href="{{ route('blogs.show', $b) }}">{{ $b->tieu_de }}</a></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($b->user)->name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($b->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-6 py-4 text-sm text-gray-500">Bạn chưa lưu bài viết nào.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-4">{{ $saved->links() }}</div>
    </div>
  </div>
  </div>
</div>
@endsection

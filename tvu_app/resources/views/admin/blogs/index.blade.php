@extends('layouts.admin')
@section('title','Admin - Quản lý blog')
@section('content')
<div class="max-w-7xl mx-auto py-4">
  <div class="admin-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between gap-3">
      <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Quản lý Blog</h2>
        <p class="mt-1 text-sm text-gray-500">Danh sách bài viết</p>
      </div>
      <div class="hidden sm:block">
        <div class="relative">
          <input type="text" placeholder="Tìm kiếm bài viết..." class="w-64 pl-9 pr-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <i data-feather="search" class="absolute left-3 top-2.5 h-4 w-4 text-gray-400"></i>
        </div>
      </div>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      <table class="min-w-full border-separate border-spacing-0">
        <thead>
          <tr>
            <th class="sticky top-0 z-10 bg-gray-50 dark:bg-gray-800/60 backdrop-blur px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-800">#</th>
            <th class="sticky top-0 z-10 bg-gray-50 dark:bg-gray-800/60 backdrop-blur px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-800">Tiêu đề</th>
            <th class="sticky top-0 z-10 bg-gray-50 dark:bg-gray-800/60 backdrop-blur px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-800">Tác giả</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
          @foreach($blogs as $b)
            <tr class="bg-white dark:bg-gray-900 hover:bg-indigo-50 dark:hover:bg-gray-800 transition-colors">
              <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ $b->id }}</td>
              <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $b->tieu_de }}</td>
              <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">{{ $b->user->name }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="mt-4">{{ $blogs->links() }}</div>
    </div>
  </div>
</div>
@endsection

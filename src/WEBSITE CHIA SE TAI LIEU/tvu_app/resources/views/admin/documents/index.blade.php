@extends('layouts.admin')
@section('title','Admin - Quản lý tài liệu')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Quản lý tài liệu</h2>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kiểm duyệt tài liệu được đăng tải</p>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      <div class="flex justify-between items-center mb-4">
        <div class="relative">
          <input type="text" id="document-search" placeholder="Tìm kiếm tài liệu..." class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
          <i data-feather="search" class="absolute left-3 top-2.5 text-gray-400 dark:text-gray-500"></i>
        </div>
      </div>

      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tên tài liệu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Người đăng</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Loại</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Giá</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Trạng thái</th>
          </tr>
        </thead>
        <tbody id="document-table-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
          @include('admin.documents.table_rows')
        </tbody>
      </table>
      <div class="mt-4">{{ $documents->links() }}</div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('document-search');
        const tableBody = document.getElementById('document-table-body');
        let searchTimeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('admin.documents.index') }}?search=${encodeURIComponent(query)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    tableBody.innerHTML = html;
                    if(window.feather) window.feather.replace();
                })
                .catch(err => console.error(err));
            }, 300);
        });
    });
</script>
@endsection

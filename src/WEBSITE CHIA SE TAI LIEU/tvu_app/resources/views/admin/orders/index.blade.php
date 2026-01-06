@extends('layouts.admin')
@section('title','Admin - Quản lý đơn hàng')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Quản lý đơn hàng</h2>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Cập nhật trạng thái đơn hàng</p>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      <div class="flex justify-between items-center mb-4">
        <div class="relative">
          <input type="text" id="order-search" placeholder="Tìm kiếm đơn hàng..." class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
          <i data-feather="search" class="absolute left-3 top-2.5 text-gray-400 dark:text-gray-500"></i>
        </div>
      </div>
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mã đơn</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Người mua</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tài liệu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Trạng thái</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Thao tác</th>
          </tr>
        </thead>
        <tbody id="order-table-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
          @include('admin.orders.table_rows')
        </tbody>
      </table>
      <div class="mt-4">{{ $orders->links() }}</div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('order-search');
        const tableBody = document.getElementById('order-table-body');
        let searchTimeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('admin.orders.index') }}?search=${encodeURIComponent(query)}`, {
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

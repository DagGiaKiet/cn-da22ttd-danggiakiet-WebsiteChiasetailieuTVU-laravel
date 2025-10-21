@extends('layouts.app')
@section('title','Admin - Quản lý đơn hàng')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-semibold text-gray-900">Quản lý đơn hàng</h2>
      <p class="mt-1 text-sm text-gray-500">Cập nhật trạng thái đơn hàng</p>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người mua</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tài liệu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($orders as $o)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $o->id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $o->user->name }}<span class="text-gray-500"> ({{ $o->user->email }})</span></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $o->document->ten_tai_lieu }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $o->trang_thai === 'dang_giao' ? 'bg-yellow-100 text-yellow-800' : ($o->trang_thai === 'da_nhan' ? 'bg-green-100 text-green-800' : ($o->trang_thai === 'huy' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                  {{ $o->trang_thai }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <form method="POST" action="{{ route('admin.orders.update-status', $o) }}" class="flex items-center space-x-2">
                  @csrf
                  <select name="trang_thai" class="border border-gray-300 rounded-md px-2 py-1 text-sm">
                    @foreach(['pending','dang_giao','da_nhan','huy'] as $s)
                      <option value="{{ $s }}" @selected($o->trang_thai===$s)>{{ $s }}</option>
                    @endforeach
                  </select>
                  <button class="px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">Lưu</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="mt-4">{{ $orders->links() }}</div>
    </div>
  </div>
</div>
@endsection

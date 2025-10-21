@extends('layouts.app')
@section('title','Đơn hàng của tôi')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-semibold text-gray-900">Đơn hàng của tôi</h2>
      <p class="mt-1 text-sm text-gray-500">Theo dõi trạng thái đơn hàng đã mua</p>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tài liệu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Xem chi tiết</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($orders as $o)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $o->id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $o->document->ten_tai_lieu }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $o->trang_thai === 'dang_giao' ? 'bg-yellow-100 text-yellow-800' : ($o->trang_thai === 'da_nhan' ? 'bg-green-100 text-green-800' : ($o->trang_thai === 'huy' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                  {{ $o->trang_thai }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <a class="text-blue-600 hover:underline" href="{{ route('orders.show', $o) }}">Xem</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="mt-4">{{ $orders->links() }}</div>
    </div>
  </div>
  <div class="mt-4">
    <a href="{{ route('profile.index') }}" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Quay lại hồ sơ</a>
  </div>
</div>
@endsection

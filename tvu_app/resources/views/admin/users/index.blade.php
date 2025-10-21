@extends('layouts.app')
@section('title','Admin - Quản lý tài khoản')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-semibold text-gray-900">Quản lý tài khoản sinh viên</h2>
      <p class="mt-1 text-sm text-gray-500">Chỉ email @st.tvu.edu.vn được phép đăng ký</p>
    </div>
    <div class="px-6 py-4">
      <div class="flex justify-between items-center mb-4">
        <div class="relative">
          <input type="text" placeholder="Tìm kiếm sinh viên..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-md">
          <i data-feather="search" class="absolute left-3 top-2.5 text-gray-400"></i>
        </div>
        <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium hover:bg-primary-700">Thêm tài khoản</a>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ tên</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $u)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $u->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->role }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mt-4">{{ $users->links() }}</div>
    </div>
  </div>
</div>
@endsection

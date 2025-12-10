@extends('layouts.admin')
@section('title','Admin - Quản lý tài khoản')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-semibold text-gray-900">Quản lý tài khoản sinh viên</h2>
      <p class="mt-1 text-sm text-gray-500">Chỉ email @st.tvu.edu.vn được phép đăng ký</p>
    </div>
    <div class="px-6 py-4">
      @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4 border border-green-200 text-green-800">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200 text-red-800">{{ session('error') }}</div>
      @endif
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
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $u)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $u->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  <form method="POST" action="{{ route('admin.users.update-role', $u) }}" class="inline-flex items-center gap-2">
                    @csrf
                    <select name="role" class="border border-gray-300 rounded-md text-sm px-2 py-1"
                      @if(auth()->id() === $u->id) disabled @endif>
                      <option value="student" {{ $u->role === 'student' ? 'selected' : '' }}>student</option>
                      <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>admin</option>
                    </select>
                    <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white rounded-md text-xs font-medium hover:bg-indigo-700 disabled:opacity-50"
                      @if(auth()->id() === $u->id) disabled @endif>
                      Lưu
                    </button>
                  </form>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  @if(auth()->id() === $u->id)
                    <span class="text-gray-400">(Tài khoản của bạn)</span>
                  @else
                    <span class="text-gray-400">&nbsp;</span>
                  @endif
                </td>
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

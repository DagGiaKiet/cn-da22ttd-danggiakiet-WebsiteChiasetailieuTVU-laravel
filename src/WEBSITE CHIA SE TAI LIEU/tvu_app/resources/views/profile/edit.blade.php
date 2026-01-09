@extends('layouts.app')
@section('title','Cập nhật hồ sơ')
@section('content')
<div class="max-w-3xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-semibold text-gray-900">Cập nhật hồ sơ</h2>
      <p class="mt-1 text-sm text-gray-500">Điền thông tin chính xác để hoàn tất hồ sơ sinh viên</p>
    </div>
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6 space-y-4">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- New Avatar Upload Field -->
        <div class="col-span-1 md:col-span-2 bg-blue-50/50 p-4 rounded-lg border border-blue-100">
          <label class="block text-sm font-semibold text-gray-800 mb-2">Ảnh đại diện (Avatar)</label>
          <p class="text-xs text-gray-500 mb-3">Hình ảnh này sẽ hiển thị công khai trên trang cá nhân, bình luận và tin nhắn.</p>
          <div class="flex items-center space-x-4">
            <div class="shrink-0">
               @if($user->avatar)
                <img class="h-16 w-16 object-cover rounded-full border-2 border-white shadow" src="{{ asset('storage/'.$user->avatar) }}" alt="Avatar" />
               @else
                <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-500 font-bold border-2 border-white shadow">
                  {{ substr($user->name, 0, 1) }}
                </div>
               @endif
            </div>
            <div class="flex-1">
               <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-slate-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-xs file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100
              "/>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Họ tên</label>
          <input name="name" value="{{ old('name',$user->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Mã SV</label>
          <input name="ma_sv" value="{{ old('ma_sv',$user->ma_sv) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Mã lớp</label>
          <input name="ma_lop" value="{{ old('ma_lop',$user->ma_lop) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        </div>
        <div></div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Khoa</label>
          <input name="khoa" value="{{ old('khoa',$user->khoa) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Ngành</label>
          <input name="nganh" value="{{ old('nganh',$user->nganh) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        </div>
      </div>

      <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mt-4">
        <label class="block text-sm font-semibold text-gray-800 mb-1">Ảnh thẻ sinh viên</label>
        <p class="text-xs text-red-500 mb-3">* Chỉ hiển thị với bạn và Quản trị viên (Admin) để xác thực.</p>
        <input type="file" name="anh_the" accept="image/*" class="mt-1 block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300" />
        @if($user->anh_the)
          <div class="mt-2">
            <img src="{{ asset('storage/'.$user->anh_the) }}" alt="Ảnh thẻ" class="w-24 h-24 rounded object-cover border" />
          </div>
        @endif
      </div>

      <div class="pt-2">
        <button class="inline-flex items-center px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700">Lưu</button>
        <a href="{{ route('profile.index') }}" class="ml-2 inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Hủy</a>
      </div>
    </form>
  </div>
</div>
@endsection

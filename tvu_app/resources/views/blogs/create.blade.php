@extends('layouts.app')
@section('title','Viết bài - Blog')
@section('content')
<div class="max-w-3xl mx-auto">
  <div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-xl font-semibold mb-4">Viết bài chia sẻ</h1>
    <form method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề</label>
        <input name="tieu_de" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Nội dung</label>
        <textarea name="noi_dung" rows="6" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh</label>
        <input type="file" name="hinh_anh" accept="image/*" class="mt-1 block w-full text-sm text-gray-600" />
      </div>
      <div class="text-right">
        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">Đăng</button>
      </div>
    </form>
  </div>
</div>
@endsection

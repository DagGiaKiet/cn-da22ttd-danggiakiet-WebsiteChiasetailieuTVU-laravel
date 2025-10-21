@extends('layouts.app')
@section('title','Liên hệ')
@section('content')
<div class="py-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
      <h2 class="text-xl font-semibold text-gray-900">Gửi tin nhắn cho chúng tôi</h2>
      <form class="mt-4 space-y-4" method="post" action="{{ route('contact.submit') }}">
        @csrf
        <div>
          <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
          <input name="name" value="{{ old('name') }}" type="text" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="Nguyễn Văn A" required>
          @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input name="email" value="{{ old('email') }}" type="email" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror" placeholder="username@st.tvu.edu.vn" required>
          @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Tiêu đề</label>
          <select name="subject" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('subject') border-red-500 @enderror">
            <option>Chọn chủ đề</option>
            <option value="Hỗ trợ kỹ thuật" @selected(old('subject')==='Hỗ trợ kỹ thuật')>Hỗ trợ kỹ thuật</option>
            <option value="Góp ý/Tính năng" @selected(old('subject')==='Góp ý/Tính năng')>Góp ý/Tính năng</option>
            <option value="Vấn đề tài liệu/đơn hàng" @selected(old('subject')==='Vấn đề tài liệu/đơn hàng')>Vấn đề tài liệu/đơn hàng</option>
            <option value="Khác" @selected(old('subject')==='Khác')>Khác</option>
          </select>
          @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Nội dung</label>
          <textarea name="message" rows="5" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('message') border-red-500 @enderror" placeholder="Mô tả chi tiết vấn đề của bạn..." required>{{ old('message') }}</textarea>
          @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <button class="inline-flex items-center px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700">Gửi</button>
        </div>
      </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
      <h2 class="text-xl font-semibold text-gray-900">Thông tin liên hệ</h2>
      <ul class="mt-4 space-y-4 text-gray-700">
        <li class="flex items-start gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 19l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
          <div>
            <div class="font-medium">Địa chỉ</div>
            <div>Phòng 123, Nhà A, Đại học Trà Vinh, 126 Nguyễn Thiện Thành, Khóm 4, Phường 5, TP. Trà Vinh</div>
          </div>
        </li>
        <li class="flex items-start gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v.217l-8 4.8-8-4.8V5z" /><path d="M18 8.383l-8 4.8-8-4.8V15a2 2 0 002 2h12a2 2 0 002-2V8.383z" /></svg>
          <div>
            <div class="font-medium">Email</div>
            <div>support@tracuasachtvu.edu.vn</div>
          </div>
        </li>
        <li class="flex items-start gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.433a1 1 0 01-.502 1.06l-1.548.89a11.037 11.037 0 006.105 6.105l.89-1.548a1 1 0 011.06-.502l4.433.74A1 1 0 0118 15.847V18a1 1 0 01-1 1h-2a15 15 0 01-15-15V4a1 1 0 011-1h2z" clip-rule="evenodd" /></svg>
          <div>
            <div class="font-medium">Điện thoại</div>
            <div>0294 3855 001 (Trong giờ hành chính)</div>
          </div>
        </li>
        <li class="flex items-start gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2a1 1 0 001 1h1v10H6a1 1 0 100 2h8a1 1 0 100-2h-1V6h1a1 1 0 001-1V3a1 1 0 00-1-1H6zm3 4h2v10H9V6z" clip-rule="evenodd" /></svg>
          <div>
            <div class="font-medium">Giờ làm việc</div>
            <div>Thứ 2 - Thứ 6: 7h30 - 11h30 | 13h30 - 17h</div>
          </div>
        </li>
      </ul>
      <div class="mt-4">
        <div class="text-gray-700 font-medium mb-2">Theo dõi chúng tôi</div>
        <div class="flex items-center gap-3">
          <a href="#" class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-blue-600 text-white">f</a>
          <a href="#" class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-sky-400 text-white">t</a>
          <a href="#" class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-pink-500 text-white">ig</a>
          <a href="#" class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-red-600 text-white">yt</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
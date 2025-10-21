@extends('layouts.app')
@section('title','Blog - Trao Đổi Sách TVU')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0">
  <div class="flex flex-col md:flex-row gap-8">
    <!-- Blog List -->
    <div class="flex-1">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Bài viết từ cộng đồng</h1>
        @auth
          <button id="newPostBtn" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">
            <i data-feather="plus" class="w-4 h-4 mr-1"></i> Bài viết mới
          </button>
        @else
          <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">Đăng nhập để viết bài</a>
        @endauth
      </div>

      <div class="space-y-6">
        @forelse($blogs as $b)
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6">
              <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                  <i data-feather="user" class="w-5 h-5"></i>
                </div>
                <div class="ml-3">
                  <h3 class="font-medium">{{ $b->user->name }}</h3>
                  <p class="text-sm text-gray-500">{{ $b->user->khoa ?? 'TVU' }} · {{ $b->created_at->diffForHumans() }}</p>
                </div>
              </div>
              <h2 class="text-xl font-semibold mb-2">
                <a class="hover:text-primary" href="{{ route('blogs.show',$b) }}">{{ $b->tieu_de }}</a>
              </h2>
              <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($b->noi_dung), 180) }}</p>
              <div class="flex items-center justify-between">
                <div class="flex space-x-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    <i data-feather="book" class="w-3 h-3 mr-1"></i> Bài viết
                  </span>
                </div>
                <a class="text-primary hover:text-primary-700 font-medium" href="{{ route('blogs.show',$b) }}">Xem chi tiết</a>
              </div>
            </div>
          </div>
        @empty
          <div class="bg-white shadow rounded-lg p-6 text-gray-600">Chưa có bài viết nào.</div>
        @endforelse
      </div>

      <div class="mt-6">{{ $blogs->links() }}</div>
    </div>

    <!-- Sidebar -->
    <div class="md:w-80 space-y-6">
      @auth
      <div class="bg-white shadow rounded-lg p-6 hidden" id="createPostForm">
        <h3 class="text-lg font-medium mb-4">Tạo bài viết mới</h3>
        <form method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề</label>
            <input name="tieu_de" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nội dung</label>
            <textarea name="noi_dung" rows="5" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh</label>
            <input type="file" name="hinh_anh" accept="image/*" class="mt-1 block w-full text-sm text-gray-600" />
          </div>
          <div class="flex justify-end space-x-3">
            <button type="button" id="cancelPostBtn" class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Hủy</button>
            <button class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">Đăng bài</button>
          </div>
        </form>
      </div>
      @endauth

      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium mb-4">Danh mục bài viết</h3>
        <ul class="space-y-2 text-gray-600">
          <li><a href="#" class="hover:text-primary-600">Tất cả bài viết</a></li>
          <li><a href="#" class="hover:text-primary-600">Chia sẻ tài liệu</a></li>
          <li><a href="#" class="hover:text-primary-600">Hẹn gặp trao đổi</a></li>
          <li><a href="#" class="hover:text-primary-600">Hỏi đáp</a></li>
          <li><a href="#" class="hover:text-primary-600">Thông báo</a></li>
        </ul>
      </div>

      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium mb-4">Thẻ phổ biến</h3>
        <div class="flex flex-wrap gap-2">
          <a href="#" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">#cntt</a>
          <a href="#" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">#kinhte</a>
          <a href="#" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">#sach</a>
          <a href="#" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">#tailieu</a>
          <a href="#" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">#traodoi</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  if (window.feather) window.feather.replace();
  const btn = document.getElementById('newPostBtn');
  const panel = document.getElementById('createPostForm');
  const cancel = document.getElementById('cancelPostBtn');
  if (btn && panel) {
    btn.addEventListener('click', () => {
      panel.classList.toggle('hidden');
      if (!panel.classList.contains('hidden')) panel.scrollIntoView({ behavior: 'smooth' });
    });
  }
  if (cancel && panel) {
    cancel.addEventListener('click', () => panel.classList.add('hidden'));
  }
});
</script>
@endpush

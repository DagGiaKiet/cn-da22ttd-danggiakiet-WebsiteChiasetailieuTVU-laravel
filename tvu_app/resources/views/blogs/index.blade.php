@extends('layouts.app')
@section('title','Bài viết - Trao Đổi Sách TVU')
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
                <div class="flex items-center gap-2">
                  @auth
                    <form method="POST" action="{{ route('blogs.like', $b) }}">
                      @csrf
                      @php $isLiked = isset($likedIds) ? $likedIds->contains($b->id) : false; @endphp
                      <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded border {{ $isLiked ? 'border-red-200 bg-red-50 text-red-600' : 'border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                        <i data-feather="heart" class="w-3 h-3"></i>
                        <span class="text-xs">{{ $b->likes_count }}</span>
                      </button>
                    </form>
                    <form method="POST" action="{{ route('blogs.save', $b) }}">
                      @csrf
                      @php $isSaved = isset($savedIds) ? $savedIds->contains($b->id) : false; @endphp
                      <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded border {{ $isSaved ? 'border-indigo-200 bg-indigo-50 text-indigo-600' : 'border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                        <i data-feather="bookmark" class="w-3 h-3"></i>
                        <span class="text-xs">Lưu</span>
                      </button>
                    </form>
                  @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-gray-200 text-gray-700 hover:bg-gray-50">
                      <i data-feather="heart" class="w-3 h-3"></i>
                      <span class="text-xs">{{ $b->likes_count }}</span>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-gray-200 text-gray-700 hover:bg-gray-50">
                      <i data-feather="bookmark" class="w-3 h-3"></i>
                      <span class="text-xs">Lưu</span>
                    </a>
                  @endauth
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
  // Modal logic for creating a post
  const openBtn = document.getElementById('newPostBtn');
  const modal = document.getElementById('blogModal');
  const backdrop = document.getElementById('blogBackdrop');
  const panel = document.getElementById('blogModalPanel');
  const closeBtns = document.querySelectorAll('[data-close-blog]');
  function open(){
    if (!modal) return;
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    // animate in
    requestAnimationFrame(()=>{
      if (backdrop){ backdrop.classList.remove('opacity-0'); backdrop.classList.add('opacity-100'); }
      if (panel){ panel.classList.remove('opacity-0','-translate-y-3','scale-95'); panel.classList.add('opacity-100','translate-y-0','scale-100'); }
    });
  }
  function close(){
    if (!modal) return;
    // animate out
    if (backdrop){ backdrop.classList.add('opacity-0'); backdrop.classList.remove('opacity-100'); }
    if (panel){ panel.classList.add('opacity-0','-translate-y-3','scale-95'); panel.classList.remove('opacity-100','translate-y-0','scale-100'); }
    setTimeout(()=>{ modal.classList.add('hidden'); document.body.classList.remove('overflow-hidden'); }, 180);
  }
  if (openBtn) openBtn.addEventListener('click', open);
  closeBtns.forEach(b => b.addEventListener('click', close));
  if (backdrop) backdrop.addEventListener('click', close);
  // Auto-open via ?new=1
  try { const usp = new URLSearchParams(window.location.search); if (usp.get('new')==='1') open(); } catch(e) {}
});
</script>
@endpush

@auth
<!-- Blog Create Modal -->
<div id="blogModal" class="hidden fixed inset-0 z-50">
  <div id="blogBackdrop" class="absolute inset-0 bg-black/40 opacity-0 transition-opacity duration-200"></div>
  <div class="relative z-10 max-w-3xl mx-auto my-8">
    <div id="blogModalPanel" class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden transform transition-all duration-200 ease-out opacity-0 -translate-y-3 scale-95">
      <div class="flex items-center justify-between px-6 py-4 border-b bg-gray-50">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
            <i data-feather="edit-3" class="w-4 h-4"></i>
          </div>
          <h3 class="text-lg font-semibold text-gray-900">Tạo bài viết mới</h3>
        </div>
        <button type="button" class="p-2 rounded-md hover:bg-gray-100 text-gray-500" aria-label="Đóng" data-close-blog>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
        </button>
      </div>
      <form method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data" class="max-h-[80vh] overflow-y-auto">
        @csrf
        <div class="p-6 space-y-5">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề <span class="text-red-500">*</span></label>
            <input name="tieu_de" required placeholder="Nhập tiêu đề bài viết" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nội dung <span class="text-red-500">*</span></label>
            <textarea name="noi_dung" rows="6" required placeholder="Viết nội dung chia sẻ của bạn..." class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh</label>
            <input type="file" name="hinh_anh" accept="image/*" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 focus:ring-2 focus:ring-primary/20 focus:border-primary" />
          </div>
        </div>
        <div class="flex items-center justify-end gap-2 px-6 py-4 border-t bg-gray-50">
          <button type="button" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-white" data-close-blog>Hủy</button>
          <button class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary-700">Đăng bài</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endauth

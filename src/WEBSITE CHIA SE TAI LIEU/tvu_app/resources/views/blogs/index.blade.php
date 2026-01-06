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
            <span class="material-symbols-outlined mr-1" style="font-size: 18px;">add</span> Bài viết mới
          </button>
        @else
          <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">Đăng nhập để viết bài</a>
        @endauth
      </div>

      <div class="space-y-6">
        @forelse($blogs as $b)
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6">
              <div class="flex items-center mb-4 cursor-pointer group" onclick="openMessageModal({{ $b->user->id }}, '{{ $b->user->name }}')">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                  <i data-feather="user" class="w-5 h-5"></i>
                </div>
                <div class="ml-3">
                  <h3 class="font-medium group-hover:text-blue-600 transition-colors">{{ $b->user->name }}</h3>
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
                        <span class="material-symbols-outlined" style="font-size: 16px; font-variation-settings: 'FILL' {{ $isLiked ? '1' : '0' }};">favorite</span>
                        <span class="text-xs">{{ $b->likes_count }}</span>
                      </button>
                    </form>
                    <form method="POST" action="{{ route('blogs.save', $b) }}">
                      @csrf
                      @php $isSaved = isset($savedIds) ? $savedIds->contains($b->id) : false; @endphp
                      <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded border {{ $isSaved ? 'border-indigo-200 bg-indigo-50 text-indigo-600' : 'border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                        <span class="material-symbols-outlined" style="font-size: 16px; font-variation-settings: 'FILL' {{ $isSaved ? '1' : '0' }};">bookmark</span>
                        <span class="text-xs">Lưu</span>
                      </button>
                    </form>
                  @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-gray-200 text-gray-700 hover:bg-gray-50">
                      <span class="material-symbols-outlined" style="font-size: 16px;">favorite</span>
                      <span class="text-xs">{{ $b->likes_count }}</span>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-gray-200 text-gray-700 hover:bg-gray-50">
                      <span class="material-symbols-outlined" style="font-size: 16px;">bookmark</span>
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

<!-- Message Modal (Liquid Glass Style) -->
<div id="messageModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <!-- Overlay -->
    <div id="msgOverlay" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0" aria-hidden="true" onclick="closeMessageModal()"></div>

    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <!-- Modal Panel -->
    <div id="msgPanel" class="inline-block align-bottom bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-white/20 dark:border-gray-700/50 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 ease-out opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      
      <div class="px-6 pt-6 pb-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-[24px]">chat_bubble</span>
            </div>
            <div>
                 <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-1">Gửi tin nhắn</h3>
                 <p class="text-sm text-gray-500 dark:text-gray-400">Gửi tin nhắn đến <span id="msgRecipientName" class="font-bold text-gray-900 dark:text-white"></span></p>
            </div>
        </div>

        <form id="messageForm" onsubmit="handleSendMessage(event)">
            @csrf
            <input type="hidden" id="msgRecipientId" name="recipient_id">
            
            <div class="space-y-4">
                <div>
                    <label for="messageContent" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nội dung tin nhắn</label>
                    <textarea id="messageContent" name="message" rows="4" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white placeholder-gray-400 transition-all shadow-sm resize-none" placeholder="Nhập tin nhắn của bạn..."></textarea>
                </div>
            </div>

            <div class="mt-6 flex flex-row-reverse gap-3">
                <button type="submit" id="btnSendMsg" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-[20px] mr-2">send</span>
                    Gửi tin nhắn
                </button>
                <button type="button" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-all" onclick="closeMessageModal()">
                    Hủy
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    function openMessageModal(userId, userName) {
        @guest
            window.location.href = "{{ route('login') }}";
            return;
        @endguest

        if(userId == {{ auth()->id() ?? 0 }}) {
            alert('Bạn không thể tự gửi tin nhắn cho chính mình!');
            return;
        }

        document.getElementById('msgRecipientId').value = userId;
        document.getElementById('msgRecipientName').innerText = userName;
        document.getElementById('messageContent').value = '';

        const modal = document.getElementById('messageModal');
        const overlay = document.getElementById('msgOverlay');
        const panel = document.getElementById('msgPanel');

        modal.classList.remove('hidden');
        
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
                
                panel.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            });
        });
    }

    function closeMessageModal() {
        const modal = document.getElementById('messageModal');
        const overlay = document.getElementById('msgOverlay');
        const panel = document.getElementById('msgPanel');

        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0');
        
        panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
        panel.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function handleSendMessage(e) {
        e.preventDefault();
        
        const btn = document.getElementById('btnSendMsg');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin mr-2">sync</span> Đang gửi...';

        const formData = new FormData(document.getElementById('messageForm'));

        fetch("{{ route('messages.send') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeMessageModal();
                // Show toast notification (simplified alert for now, can be upgraded)
                alert('Tin nhắn đã được gửi thành công!');
            } else {
                alert('Có lỗi xảy ra: ' + (data.message || 'Vui lòng thử lại'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi gửi tin nhắn.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }
</script>
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

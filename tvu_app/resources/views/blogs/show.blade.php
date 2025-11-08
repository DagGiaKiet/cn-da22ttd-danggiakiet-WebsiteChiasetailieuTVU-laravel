@extends('layouts.app')
@section('title', $blog->tieu_de . ' - Bài viết')
@section('content')
<div class="max-w-3xl mx-auto">
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="p-6">
      <div class="flex items-center mb-4">
        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
          <i data-feather="user" class="w-5 h-5"></i>
        </div>
        <div class="ml-3">
          <h3 class="font-medium">{{ $blog->user->name }}</h3>
          <p class="text-sm text-gray-500">{{ $blog->created_at->format('d/m/Y H:i') }}</p>
        </div>
      </div>

      <h1 class="text-2xl font-bold mb-3">{{ $blog->tieu_de }}</h1>
      @if($blog->hinh_anh)
        <img class="w-full max-h-[420px] object-cover rounded mb-4" src="{{ asset('storage/'.$blog->hinh_anh) }}" alt="{{ $blog->tieu_de }}" />
      @endif
      <div class="prose max-w-none">
        {!! nl2br(e($blog->noi_dung)) !!}
      </div>

      {{-- Actions: like, comment toggle, save --}}
      <div class="mt-4 flex items-center gap-3">
        @auth
          <form method="POST" action="{{ route('blogs.like', $blog) }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border {{ $liked ? 'border-red-200 bg-red-50 text-red-600' : 'border-gray-200 text-gray-700 hover:bg-gray-50' }}">
              <i data-feather="heart" class="w-4 h-4"></i>
              <span>{{ $blog->likes_count }}</span>
            </button>
          </form>
          <button id="toggleCommentBtn" type="button" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50">
            <i data-feather="message-circle" class="w-4 h-4"></i>
            <span>Bình luận</span>
          </button>
          <form method="POST" action="{{ route('blogs.save', $blog) }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border {{ $saved ? 'border-indigo-200 bg-indigo-50 text-indigo-600' : 'border-gray-200 text-gray-700 hover:bg-gray-50' }}">
              <i data-feather="bookmark" class="w-4 h-4"></i>
              <span>Lưu</span>
            </button>
          </form>
        @else
          <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50">
            <i data-feather="heart" class="w-4 h-4"></i>
            <span>{{ $blog->likes_count }}</span>
          </a>
          <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50">
            <i data-feather="message-circle" class="w-4 h-4"></i>
            <span>Bình luận</span>
          </a>
          <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50">
            <i data-feather="bookmark" class="w-4 h-4"></i>
            <span>Lưu</span>
          </a>
        @endauth
      </div>
    </div>
  </div>

  <div class="mt-6 bg-white shadow rounded-lg p-6" id="commentsSection">
    <h2 class="text-lg font-semibold mb-4">Bình luận</h2>
    @auth
      <form method="POST" action="{{ route('blogs.comment', $blog) }}" class="mb-6 hidden" id="commentForm">
        @csrf
        <textarea name="noi_dung" rows="3" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" placeholder="Viết bình luận..."></textarea>
        <div class="mt-2 text-right">
          <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">Gửi</button>
        </div>
      </form>
    @else
      <p class="text-gray-600">Vui lòng <a class="text-primary hover:text-primary-700" href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
    @endauth

    <div class="space-y-3">
      @forelse($blog->comments as $c)
        <div class="border border-gray-100 rounded p-3">
          <div class="text-sm text-gray-700"><strong>{{ $c->user->name }}</strong></div>
          <div class="text-gray-800">{{ $c->noi_dung }}</div>
        </div>
      @empty
        <div class="text-gray-600">Chưa có bình luận nào.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  if (window.feather) window.feather.replace();
  const btn = document.getElementById('toggleCommentBtn');
  const form = document.getElementById('commentForm');
  if (btn && form) {
    btn.addEventListener('click', ()=>{
      form.classList.toggle('hidden');
      if (!form.classList.contains('hidden')) form.querySelector('textarea')?.focus();
    });
  }
});
</script>
@endpush

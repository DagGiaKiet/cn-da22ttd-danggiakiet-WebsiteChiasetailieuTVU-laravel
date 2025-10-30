@extends('layouts.app')
@section('title','Hồ sơ cá nhân')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  {{-- Header and action --}}
  <div class="flex items-center justify-between mb-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Hồ sơ của tôi</h1>
      <p class="text-sm text-gray-500">Quản lý thông tin cá nhân và hoạt động của bạn</p>
    </div>
    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700">Cập nhật</a>
  </div>

  {{-- Summary cards (admin-like) --}}
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
    <div class="bg-white border border-gray-200 rounded-lg p-4">
      <div class="text-sm text-gray-600">Tài liệu đã đăng</div>
      <div class="mt-1 text-2xl font-semibold">{{ $documentsCount ?? ($user->documents->count() ?? 0) }}</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
      <div class="text-sm text-gray-600">Đơn hàng của bạn</div>
      <div class="mt-1 text-2xl font-semibold">{{ $ordersCount ?? ($user->orders->count() ?? 0) }}</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
      <div class="text-sm text-gray-600">Bài viết blog</div>
      <div class="mt-1 text-2xl font-semibold">{{ $blogsCount ?? ($user->blogs->count() ?? 0) }}</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
      <div class="text-sm text-gray-600">Tài liệu đã lưu</div>
      <div class="mt-1 flex items-center justify-between">
        <div class="text-2xl font-semibold">{{ $savedDocumentsCount ?? 0 }}</div>
        <a href="{{ route('profile.saved-documents') }}" class="inline-flex items-center px-3 py-1.5 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm">Xem</a>
      </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
      <div class="text-sm text-gray-600">Bài viết đã lưu</div>
      <div class="mt-1 flex items-center justify-between">
        <div class="text-2xl font-semibold">{{ $savedBlogsCount ?? 0 }}</div>
        <a href="{{ route('profile.saved-blogs') }}" class="inline-flex items-center px-3 py-1.5 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm">Xem</a>
      </div>
    </div>
  </div>

  {{-- Profile card --}}
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-semibold text-gray-900">Thông tin cá nhân</h2>
      <p class="mt-1 text-sm text-gray-500">Chi tiết hồ sơ sinh viên</p>
    </div>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <div class="w-40 h-40 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
            @if($user->anh_the)
              <img src="{{ asset('storage/'.$user->anh_the) }}" alt="Ảnh thẻ" class="w-full h-full object-cover">
            @else
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
            @endif
          </div>
          <div class="mt-3">
            <div class="text-lg font-medium text-gray-900">{{ $user->name }}</div>
            <div class="text-sm text-gray-500">{{ $user->email }}</div>
            <span class="inline-flex mt-2 items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
              {{ $user->isAdmin() ? 'Quản trị viên' : 'Thành viên' }}
            </span>
          </div>
        </div>
        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <div class="text-sm text-gray-500">Mã sinh viên</div>
            <div class="text-base text-gray-900">{{ $user->ma_sv ?: '—' }}</div>
          </div>
          <div>
            <div class="text-sm text-gray-500">Mã lớp</div>
            <div class="text-base text-gray-900">{{ $user->ma_lop ?: '—' }}</div>
          </div>
          <div>
            <div class="text-sm text-gray-500">Khoa</div>
            <div class="text-base text-gray-900">{{ $user->khoa ?: '—' }}</div>
          </div>
          <div>
            <div class="text-sm text-gray-500">Ngành</div>
            <div class="text-base text-gray-900">{{ $user->nganh ?: '—' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Quick links --}}
  <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
    <a href="{{ route('profile.documents') }}" class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow">
      <div class="text-sm text-gray-600">Xem tài liệu của tôi</div>
      <div class="mt-1 text-base text-blue-600">Tới danh sách →</div>
    </a>
    <a href="{{ route('profile.orders') }}" class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow">
      <div class="text-sm text-gray-600">Xem đơn hàng của tôi</div>
      <div class="mt-1 text-base text-blue-600">Tới danh sách →</div>
    </a>
  </div>

  @if($user->isAdmin())
  {{-- Admin-like: Quản lý tài khoản sinh viên --}}
  <div class="mt-6 bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold text-gray-900">Quản lý tài khoản sinh viên</h2>
        <p class="mt-1 text-sm text-gray-500">Chỉ email @st.tvu.edu.vn được phép đăng ký</p>
      </div>
      <form method="GET" class="w-full md:w-auto md:flex items-center gap-2 md:justify-end">
        <div class="relative w-full md:w-72">
          <input type="text" name="user_q" value="{{ $userSearch ?? '' }}" placeholder="Tìm kiếm sinh viên..." class="w-full rounded-md border border-gray-300 pl-10 pr-3 py-2 text-sm" />
          <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M10 18a8 8 0 100-16 8 8 0 000 16z" /></svg>
        </div>
        <button class="inline-flex items-center px-3 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm mt-2 md:mt-0">Tìm</button>
      </form>
    </div>
    <div class="px-6 py-4">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ tên</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khoa</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse(($users ?? []) as $u)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $u->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->khoa ?: '—' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @php $isOnline = auth()->check() && auth()->id() === $u->id; @endphp
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isOnline ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $isOnline ? 'Hoạt động' : 'Không hoạt động' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($u->created_at)->format('d/m/Y H:i') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-4 text-sm text-gray-500">Chưa có tài khoản nào.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if(isset($users) && method_exists($users, 'links'))
        <div class="mt-4">{{ $users->links() }}</div>
      @endif

      {{-- Recent registrations --}}
      <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Tài khoản mới đăng ký</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
          @forelse(($recentUsers ?? []) as $ru)
            <div class="border border-gray-200 rounded-lg p-3 bg-white">
              <div class="font-medium text-gray-900">{{ $ru->name }}</div>
              <div class="text-sm text-gray-600">{{ $ru->email }}</div>
              <div class="text-xs text-gray-500 mt-1">{{ optional($ru->created_at)->diffForHumans() }}</div>
            </div>
          @empty
            <div class="text-sm text-gray-500">Chưa có đăng ký mới.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  @endif

  {{-- Admin-like: Quản lý đơn hàng --}}
  <div class="mt-6 bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold text-gray-900">Quản lý đơn hàng</h2>
        <p class="mt-1 text-sm text-gray-500">Cập nhật trạng thái đơn hàng</p>
      </div>
      <form method="GET" class="flex items-center space-x-2">
        <input type="hidden" name="_" value="orders" />
        <div class="relative">
          <input name="q" value="{{ $q ?? '' }}" placeholder="Tìm kiếm đơn hàng..." class="w-64 rounded-md border border-gray-300 pl-10 pr-3 py-2 text-sm" />
          <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M10 18a8 8 0 100-16 8 8 0 000 16z" /></svg>
        </div>
        <select name="status" class="rounded-md border border-gray-300 py-2 px-2 text-sm">
          <option value="">Tất cả trạng thái</option>
          @foreach(['pending' => 'Chờ xử lý','dang_giao' => 'Đang giao','da_nhan' => 'Đã nhận','huy' => 'Hủy'] as $val => $label)
            <option value="{{ $val }}" @selected(($status ?? '')===$val)>{{ $label }}</option>
          @endforeach
        </select>
        <button class="inline-flex items-center px-3 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm">Lọc</button>
      </form>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tài liệu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse(($orders ?? []) as $o)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $o->id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $o->document->ten_tai_lieu }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $o->trang_thai === 'dang_giao' ? 'bg-yellow-100 text-yellow-800' : ($o->trang_thai === 'da_nhan' ? 'bg-green-100 text-green-800' : ($o->trang_thai === 'huy' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                  {{ $o->trang_thai }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <div class="flex items-center space-x-2">
                  <a class="text-blue-600 hover:underline" href="{{ route('orders.show', $o) }}">Xem</a>
                  @if(auth()->user() && auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('profile.orders.update-status', $o) }}" class="flex items-center space-x-2">
                      @csrf
                      <select name="trang_thai" class="border border-gray-300 rounded-md px-2 py-1 text-sm">
                        @foreach(['pending','dang_giao','da_nhan','huy'] as $s)
                          <option value="{{ $s }}" @selected($o->trang_thai===$s)>{{ $s }}</option>
                        @endforeach
                      </select>
                      <button class="px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">Lưu</button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-6 py-4 text-sm text-gray-500">Bạn chưa có đơn hàng nào.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      @if(isset($orders))
        <div class="mt-4">{{ $orders->links() }}</div>
      @endif
    </div>
  </div>

  @if($user->isAdmin())
  {{-- Admin-like: Quản lý danh mục --}}
  <div class="mt-6 bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-semibold text-gray-900">Quản lý danh mục</h2>
      <p class="mt-1 text-sm text-gray-500">Khoa - Ngành - Môn học</p>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="border rounded-lg p-4">
        <div class="flex items-center justify-between">
          <div class="font-medium text-gray-900">Khoa</div>
          <a href="{{ route('admin.khoas.index') }}" class="text-blue-600 text-sm hover:underline">Thêm mới</a>
        </div>
        <div class="mt-3 text-sm text-gray-700">
          {{ optional(\App\Models\Khoa::first())->ten_khoa ?? '—' }}
        </div>
        <div class="mt-2 text-sm">
          <a href="{{ route('admin.khoas.index') }}" class="text-blue-600 hover:underline mr-3">Sửa</a>
          <a href="{{ route('admin.khoas.index') }}" class="text-red-600 hover:underline">Xóa</a>
        </div>
      </div>

      <div class="border rounded-lg p-4">
        <div class="flex items-center justify-between">
          <div class="font-medium text-gray-900">Ngành</div>
          <a href="{{ route('admin.nganhs.index') }}" class="text-blue-600 text-sm hover:underline">Thêm mới</a>
        </div>
        <div class="mt-3 text-sm text-gray-700">
          {{ optional(\App\Models\Nganh::first())->ten_nganh ?? '—' }}
        </div>
        <div class="mt-2 text-sm">
          <a href="{{ route('admin.nganhs.index') }}" class="text-blue-600 hover:underline mr-3">Sửa</a>
          <a href="{{ route('admin.nganhs.index') }}" class="text-red-600 hover:underline">Xóa</a>
        </div>
      </div>

      <div class="border rounded-lg p-4">
        <div class="flex items-center justify-between">
          <div class="font-medium text-gray-900">Môn học</div>
          <a href="{{ route('admin.mons.index') }}" class="text-blue-600 text-sm hover:underline">Thêm mới</a>
        </div>
        <div class="mt-3 text-sm text-gray-700">
          {{ optional(\App\Models\Mon::first())->ten_mon ?? '—' }}
        </div>
        <div class="mt-2 text-sm">
          <a href="{{ route('admin.mons.index') }}" class="text-blue-600 hover:underline mr-3">Sửa</a>
          <a href="{{ route('admin.mons.index') }}" class="text-red-600 hover:underline">Xóa</a>
        </div>
      </div>
    </div>
  </div>

  {{-- Admin-like: Quản lý bài đăng Blog --}}
  <div class="mt-6 bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold text-gray-900">Quản lý bài đăng Blog</h2>
        <p class="mt-1 text-sm text-gray-500">Kiểm duyệt bài đăng từ cộng đồng</p>
      </div>
      <form method="GET" class="flex items-center space-x-2">
        <input type="hidden" name="__" value="blogs" />
        <div class="relative">
          <input name="q_blog" value="{{ request('q_blog','') }}" placeholder="Tìm kiếm bài đăng..." class="w-64 rounded-md border border-gray-300 pl-10 pr-3 py-2 text-sm" />
          <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M10 18a8 8 0 100-16 8 8 0 000 16z" /></svg>
        </div>
        <select name="blog_status" class="rounded-md border border-gray-300 py-2 px-2 text-sm">
          <option value="">Tất cả trạng thái</option>
          <option value="pending" @selected(request('blog_status')==='pending')>Chờ duyệt</option>
          <option value="approved" @selected(request('blog_status')==='approved')>Đã duyệt</option>
          <option value="hidden" @selected(request('blog_status')==='hidden')>Ẩn</option>
        </select>
        <button class="inline-flex items-center px-3 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm">Lọc</button>
      </form>
    </div>
    <div class="p-6">
      @php
        $blogQuery = \App\Models\Blog::with('user')->latest();
        if(request('q_blog')){ $blogQuery->where('tieu_de','like','%'.request('q_blog').'%'); }
        if(in_array(request('blog_status'),['pending','approved','hidden'])){ $blogQuery->where('trang_thai', request('blog_status')); }
        $blog = $blogQuery->first();
      @endphp
      @if($blog)
        <div class="border rounded-lg p-4 bg-yellow-50/40">
          <div class="flex items-center justify-between">
            <div>
              <div class="font-semibold text-gray-900">{{ $blog->tieu_de }}</div>
              <div class="text-sm text-gray-500">Đăng bởi: {{ $blog->user->name }} - {{ $blog->created_at->diffForHumans() }}</div>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $blog->trang_thai==='approved' ? 'bg-green-100 text-green-800' : ($blog->trang_thai==='hidden' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
              {{ $blog->trang_thai==='pending' ? 'Chờ duyệt' : ($blog->trang_thai==='approved' ? 'Đã duyệt' : 'Ẩn') }}
            </span>
          </div>
          <p class="mt-2 text-sm text-gray-700 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($blog->noi_dung), 180) }}</p>
          <div class="mt-3 flex items-center space-x-2">
            <form method="POST" action="{{ route('blogs.update', $blog) }}">
              @csrf @method('PUT')
              <input type="hidden" name="trang_thai" value="approved" />
              <button class="px-3 py-1 rounded-md text-white bg-green-600 hover:bg-green-700 text-sm" type="submit">Duyệt</button>
            </form>
            <a href="{{ route('blogs.show', $blog) }}" class="px-3 py-1 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">Xem chi tiết</a>
            <form method="POST" action="{{ route('blogs.update', $blog) }}">
              @csrf @method('PUT')
              <input type="hidden" name="trang_thai" value="hidden" />
              <button class="px-3 py-1 rounded-md text-white bg-red-600 hover:bg-red-700 text-sm" type="submit">Ẩn bài</button>
            </form>
          </div>
        </div>
      @else
        <div class="text-sm text-gray-500">Không có bài đăng phù hợp.</div>
      @endif
    </div>
  </div>

  {{-- Admin-like: Quản lý tài liệu --}}
  <div class="mt-6 bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold text-gray-900">Quản lý tài liệu</h2>
        <p class="mt-1 text-sm text-gray-500">Kiểm duyệt tài liệu được đăng tải</p>
      </div>
      <form method="GET" class="flex items-center space-x-2">
        <input type="hidden" name="___" value="documents" />
        <div class="relative">
          <input name="q_doc" value="{{ request('q_doc','') }}" placeholder="Tìm kiếm tài liệu..." class="w-64 rounded-md border border-gray-300 pl-10 pr-3 py-2 text-sm" />
          <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M10 18a8 8 0 100-16 8 8 0 000 16z" /></svg>
        </div>
        <select name="doc_status" class="rounded-md border border-gray-300 py-2 px-2 text-sm">
          <option value="">Tất cả trạng thái</option>
          <option value="pending" @selected(request('doc_status')==='pending')>Chờ duyệt</option>
          <option value="approved" @selected(request('doc_status')==='approved')>Đã duyệt</option>
          <option value="hidden" @selected(request('doc_status')==='hidden')>Ẩn</option>
        </select>
        <button class="inline-flex items-center px-3 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm">Lọc</button>
      </form>
    </div>
    <div class="px-6 py-4 overflow-x-auto">
      @php
        $docQuery = \App\Models\Document::with('user','nganh','khoa')->latest();
        if(request('q_doc')){ $docQuery->where('ten_tai_lieu','like','%'.request('q_doc').'%'); }
        if(in_array(request('doc_status'),['pending','approved','hidden'])){ $docQuery->where('trang_thai_duyet', request('doc_status')); }
  $docs = $docQuery->paginate(5);
      @endphp
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên tài liệu</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người đăng</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khoa</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngành</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($docs as $d)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600"><a href="{{ route('documents.show', $d) }}">{{ $d->ten_tai_lieu }}</a></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $d->user->name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($d->khoa)->ten_khoa }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($d->nganh)->ten_nganh }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $d->trang_thai_duyet==='approved' ? 'bg-green-100 text-green-800' : ($d->trang_thai_duyet==='hidden' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                  {{ $d->trang_thai_duyet==='pending' ? 'Chờ duyệt' : ($d->trang_thai_duyet==='approved' ? 'Đã duyệt' : 'Ẩn') }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <form method="POST" action="{{ route('documents.update', $d) }}" class="inline">
                  @csrf @method('PUT')
                  <input type="hidden" name="trang_thai_duyet" value="approved" />
                  <button class="text-green-700 hover:underline mr-3">Duyệt</button>
                </form>
                <a class="text-blue-600 hover:underline mr-3" href="{{ route('documents.show', $d) }}">Xem</a>
                <form method="POST" action="{{ route('documents.update', $d) }}" class="inline">
                  @csrf @method('PUT')
                  <input type="hidden" name="trang_thai_duyet" value="hidden" />
                  <button class="text-red-600 hover:underline">Ẩn</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-6 py-4 text-sm text-gray-500">Không có tài liệu phù hợp.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      @if(method_exists($docs, 'links'))
        <div class="mt-4">{{ $docs->links() }}</div>
      @endif
    </div>
  </div>
  @endif
</div>
@endsection

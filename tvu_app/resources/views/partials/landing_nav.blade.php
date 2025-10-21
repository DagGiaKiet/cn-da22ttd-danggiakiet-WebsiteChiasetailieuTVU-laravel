<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 items-center h-14">
            <div class="hidden md:block"></div>
            <div class="text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center">
                    <span class="ml-0 text-sm font-semibold tracking-wide text-gray-900">Trao Đổi Sách TVU</span>
                </a>
            </div>
                        <div class="flex items-center justify-end space-x-6 text-sm">
                <a href="{{ url('/') }}" class="nav-link text-gray-900">Trang chủ</a>
                <a href="{{ route('categories.search') }}" class="nav-link text-gray-500 hover:text-gray-900">Danh mục</a>
                <a href="{{ route('blogs.index') }}" class="nav-link text-gray-500 hover:text-gray-900">Blog</a>
                <a href="{{ route('cart.index') }}" class="nav-link text-gray-500 hover:text-gray-900">Giỏ hàng</a>
                <a href="{{ route('contact') }}" class="nav-link text-gray-500 hover:text-gray-900">Liên hệ</a>
                                @auth
                                    <div class="relative ml-4" x-data="{open:false}" id="user-menu-root">
                                        <button id="user-menu-button" type="button" class="inline-flex items-center px-3 py-1.5 rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            {{ Auth::user()->name }}
                                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/></svg>
                                        </button>
                                        <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                            <div class="py-1 text-sm text-gray-700">
                                                @if(method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-50">Trang quản trị</a>
                                                @endif
                                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 hover:bg-gray-50">Hồ sơ</a>
                                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-gray-50">Đơn hàng</a>
                                                <form method="POST" action="{{ route('logout') }}" class="border-t mt-1">
                                                    @csrf
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-50">Đăng xuất</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="ml-4 inline-flex items-center px-3 py-1.5 rounded-md text-white bg-blue-600 hover:bg-blue-700">Đăng Nhập</a>
                                @endauth
            </div>
        </div>
    </div>
</nav>
                <script>
                  // Minimal dropdown toggling without Alpine
                  (function(){
                    const root = document.getElementById('user-menu-root');
                    if(!root) return;
                    const btn = document.getElementById('user-menu-button');
                    const menu = document.getElementById('user-menu');
                    if(!btn || !menu) return;
                    function close(){ menu.classList.add('hidden'); }
                    function open(){ menu.classList.remove('hidden'); }
                    btn.addEventListener('click', function(e){ e.stopPropagation(); if(menu.classList.contains('hidden')) open(); else close(); });
                    document.addEventListener('click', function(){ close(); });
                    // prevent closing when clicking inside
                    menu.addEventListener('click', function(e){ e.stopPropagation(); });
                  })();
                 </script>

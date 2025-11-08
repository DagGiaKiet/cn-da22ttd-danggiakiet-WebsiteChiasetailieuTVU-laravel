<nav class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-14 flex items-center justify-between">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 font-semibold text-gray-900">
                <i data-feather="book-open" class="text-indigo-600"></i>
                <span>Trao Đổi Sách TVU</span>
            </a>

            <!-- Desktop nav -->
            <div class="hidden md:flex items-center gap-6 text-sm">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1 border-b-2 {{ request()->is('/') ? 'border-indigo-600 text-gray-900' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-indigo-600' }} pb-0.5 transition-colors">Trang chủ</a>
                <a href="{{ route('categories.search') }}" class="inline-flex items-center gap-1 border-b-2 {{ request()->routeIs('categories.*') ? 'border-indigo-600 text-gray-900' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-indigo-600' }} pb-0.5 transition-colors">Danh mục</a>
                <a href="{{ route('blogs.index') }}" class="inline-flex items-center gap-1 border-b-2 {{ request()->routeIs('blogs.*') ? 'border-indigo-600 text-gray-900' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-indigo-600' }} pb-0.5 transition-colors">Bài viết</a>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-1 border-b-2 {{ request()->routeIs('contact') ? 'border-indigo-600 text-gray-900' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-indigo-600' }} pb-0.5 transition-colors">Liên hệ</a>
            </div>

            <!-- Right side: auth + hamburger -->
            <div class="flex items-center gap-2">
                @php
                    $cartCount = auth()->check()
                        ? \App\Models\Cart::where('user_id', auth()->id())->count()
                        : (is_array(session('cart')) ? count(session('cart')) : 0);
                @endphp
                <!-- Cart icon -->
                <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center p-2 rounded-md hover:bg-gray-100" aria-label="Giỏ hàng" title="Giỏ hàng">
                    <i data-feather="shopping-cart"></i>
                    @if(($cartCount ?? 0) > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 text-xs font-semibold rounded-full bg-red-600 text-white">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                @auth
                    <div class="relative" id="user-menu-root">
                        <button id="user-menu-button" type="button" class="hidden sm:inline-flex items-center px-3 py-1.5 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
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
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-3 py-1.5 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Đăng Nhập</a>
                @endauth
                <!-- Hamburger -->
                <button id="hamburger" class="md:hidden p-2 rounded-md hover:bg-gray-100" aria-label="Mở menu">
                    <i data-feather="menu"></i>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden pb-3">
            <div class="pt-2 flex flex-col gap-1 text-sm">
                <a href="{{ url('/') }}" class="px-2 py-2 rounded-md {{ request()->is('/') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">Trang chủ</a>
                <a href="{{ route('categories.search') }}" class="px-2 py-2 rounded-md {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">Danh mục</a>
                <a href="{{ route('blogs.index') }}" class="px-2 py-2 rounded-md {{ request()->routeIs('blogs.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">Bài viết</a>
                <a href="{{ route('contact') }}" class="px-2 py-2 rounded-md {{ request()->routeIs('contact') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">Liên hệ</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-2 py-2 rounded-md text-gray-700 hover:bg-gray-50">Trang quản trị</a>
                    <a href="{{ route('profile.index') }}" class="px-2 py-2 rounded-md text-gray-700 hover:bg-gray-50">Hồ sơ</a>
                    <a href="{{ route('orders.index') }}" class="px-2 py-2 rounded-md text-gray-700 hover:bg-gray-50">Đơn hàng</a>
                    <form method="POST" action="{{ route('logout') }}" class="px-2 pt-2 border-t mt-1">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-red-600 hover:bg-gray-50 rounded-md">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-2 py-2 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Đăng Nhập</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // User dropdown
    (function(){
        const root = document.getElementById('user-menu-root');
        if(!root) return;
        const btn = document.getElementById('user-menu-button');
        const menu = document.getElementById('user-menu');
        if(!btn || !menu) return;
        function close(){ menu.classList.add('hidden'); }
        function open(){ menu.classList.remove('hidden'); }
        btn.addEventListener('click', function(e){ e.stopPropagation(); menu.classList.contains('hidden')?open():close(); });
        document.addEventListener('click', function(){ close(); });
        menu.addEventListener('click', function(e){ e.stopPropagation(); });
    })();

    // Mobile menu toggle
    (function(){
        const burger = document.getElementById('hamburger');
        const panel = document.getElementById('mobile-menu');
        if(!burger || !panel) return;
        burger.addEventListener('click', function(){ panel.classList.toggle('hidden'); });
    })();
</script>



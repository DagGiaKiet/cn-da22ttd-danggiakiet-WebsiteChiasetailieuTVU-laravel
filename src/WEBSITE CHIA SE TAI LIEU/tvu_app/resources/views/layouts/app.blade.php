<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trao Đổi Sách TVU')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('static/favicon.ico') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    
    <!-- Tailwind Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2563eb",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101c22",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
                },
            },
        }
    </script>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 20px;
        }
        .glass-effect {
            background-color: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }
        .dark .glass-effect {
            background-color: rgba(26, 38, 47, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="font-display">
    <div class="relative flex min-h-screen w-full flex-col bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <div class="absolute left-[-10rem] top-[-10rem] h-96 w-96 rounded-full bg-primary/20 blur-3xl filter"></div>
            <div class="absolute bottom-[-5rem] right-[-10rem] h-96 w-96 rounded-full bg-pink-500/10 blur-3xl filter"></div>
            <div class="absolute bottom-[20rem] left-[15rem] h-64 w-64 rounded-full bg-purple-500/10 blur-3xl filter"></div>
        </div>

        <div class="relative z-10 layout-container flex h-full grow flex-col">
            <!-- Navigation Header -->
            <div class="fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 py-5">
                <div class="layout-content-container mx-auto flex max-w-7xl flex-1 flex-col">
                    <header class="flex items-center justify-between whitespace-nowrap rounded-xl px-6 py-3 bg-white/20 dark:bg-slate-900/20 backdrop-blur-xl border border-white/30 dark:border-white/10 shadow-lg shadow-black/5">
                        <div class="flex items-center gap-8">
                            <div class="flex items-center gap-3 text-slate-800 dark:text-white">
                                <div class="size-8 text-primary">
                                    <span class="material-symbols-outlined" style="font-size: 32px;">menu_book</span>
                                </div>
                                <a href="{{ route('home') }}" class="text-lg font-bold leading-tight tracking-[-0.015em] text-slate-800 dark:text-white">Trao Đổi Sách TVU</a>
                            </div>
                        </div>
                        
                        <!-- Desktop Menu -->
                        <div class="hidden lg:flex flex-1 items-center justify-center">
                            <div class="flex items-center gap-3 text-slate-700 dark:text-slate-300">
                                <a class="text-sm font-medium leading-normal px-4 py-2 rounded-full hover:bg-white/50 dark:hover:bg-white/10 transition-all {{ request()->routeIs('home') ? 'bg-white/60 dark:bg-white/20 text-primary' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                                <a class="text-sm font-medium leading-normal px-4 py-2 rounded-full hover:bg-white/50 dark:hover:bg-white/10 transition-all {{ request()->routeIs('categories.*') || request()->is('danh-muc*') ? 'bg-white/60 dark:bg-white/20 text-primary' : '' }}" href="{{ route('danh-muc') }}">Danh mục</a>
                                <a class="text-sm font-medium leading-normal px-4 py-2 rounded-full hover:bg-white/50 dark:hover:bg-white/10 transition-all {{ request()->routeIs('blogs.*') ? 'bg-white/60 dark:bg-white/20 text-primary' : '' }}" href="{{ route('blogs.index') }}">Bài viết</a>
                                <a class="text-sm font-medium leading-normal px-4 py-2 rounded-full hover:bg-white/50 dark:hover:bg-white/10 transition-all {{ request()->routeIs('contact') ? 'bg-white/60 dark:bg-white/20 text-primary' : '' }}" href="{{ route('contact') }}">Liên hệ</a>
                            </div>
                        </div>
                        
                        <!-- Right Side Buttons -->
                        <div class="flex items-center gap-3">
                            <!-- Messages/Notifications Bell Icon -->
                            <a href="#" id="messagesNotificationBtn" class="relative flex items-center justify-center size-10 rounded-full hover:bg-white/50 dark:hover:bg-white/10 transition-all">
                                <span class="material-symbols-outlined text-slate-700 dark:text-slate-300">notifications</span>
                                <span id="messagesBadge" class="hidden absolute -top-1 -right-1 flex items-center justify-center min-w-[20px] h-5 px-1 text-xs font-bold text-white bg-red-500 rounded-full">0</span>
                            </a>

                            <!-- Cart Icon -->
                            <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center size-10 rounded-full hover:bg-white/50 dark:hover:bg-white/10 transition-all {{ request()->routeIs('cart.*') ? 'bg-white/60 dark:bg-white/20' : '' }}">
                                <span class="material-symbols-outlined text-slate-700 dark:text-slate-300">shopping_cart</span>
                                @if($cartCount > 0)
                                    <span class="absolute -top-1 -right-1 flex items-center justify-center min-w-[20px] h-5 px-1 text-xs font-bold text-white bg-red-500 rounded-full">{{ $cartCount }}</span>
                                @endif
                            </a>

                            @auth
                                <div class="relative">
                                    <button id="userMenuButton" type="button" class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-primary/20 text-primary dark:bg-white/10 dark:text-white text-sm font-bold leading-normal tracking-[0.015em] transition-colors hover:bg-primary/30 dark:hover:bg-white/20">
                                        <span class="truncate">{{ Auth::user()->name }}</span>
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-56 rounded-xl glass-effect shadow-lg py-2 z-50">
                                        <a href="{{ route('profile.index') }}" class="flex items-center px-4 py-2 text-sm text-slate-800 dark:text-white hover:bg-white/30 dark:hover:bg-white/10">
                                            <span class="material-symbols-outlined text-sm mr-2" style="font-size: 16px;">person</span>
                                            Thông tin cá nhân
                                        </a>
                                        <a href="{{ route('profile.documents') }}" class="flex items-center px-4 py-2 text-sm text-slate-800 dark:text-white hover:bg-white/30 dark:hover:bg-white/10">
                                            <span class="material-symbols-outlined text-sm mr-2" style="font-size: 16px;">description</span>
                                            Tài liệu của tôi
                                        </a>
                                        <a href="{{ route('profile.orders') }}" class="flex items-center px-4 py-2 text-sm text-slate-800 dark:text-white hover:bg-white/30 dark:hover:bg-white/10">
                                            <span class="material-symbols-outlined text-sm mr-2" style="font-size: 16px;">shopping_bag</span>
                                            Đơn hàng
                                        </a>
                                        @if(Auth::user()->isAdmin())
                                            <div class="border-t border-white/20 my-2"></div>
                                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-800 dark:text-white hover:bg-white/30 dark:hover:bg-white/10">
                                                <span class="material-symbols-outlined text-sm mr-2" style="font-size: 16px;">settings</span>
                                                Quản trị
                                            </a>
                                        @endif
                                        <div class="border-t border-white/20 my-2"></div>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-2 text-sm text-slate-800 dark:text-white hover:bg-white/30 dark:hover:bg-white/10">
                                            <span class="material-symbols-outlined text-sm mr-2" style="font-size: 16px;">logout</span>
                                            Đăng xuất
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] transition-colors hover:bg-primary/90">
                                    <span class="truncate">Đăng Nhập</span>
                                </a>
                            @endauth
                        </div>
                    </header>
                </div>
            </div>

            <!-- Content -->
            <div class="pt-[120px]">
                <div class="layout-content-container flex flex-1 flex-col">
                    <!-- Flash Messages -->
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="mx-auto max-w-7xl">
                            @if(session('success'))
                                <div class="rounded-xl glass-effect p-4 mb-4 border-l-4 border-green-500">
                                    <div class="flex items-center">
                                        <span class="material-symbols-outlined text-green-500 mr-3">check_circle</span>
                                        <p class="text-slate-800 dark:text-white">{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="rounded-xl glass-effect p-4 mb-4 border-l-4 border-red-500">
                                    <div class="flex items-center">
                                        <span class="material-symbols-outlined text-red-500 mr-3">error</span>
                                        <p class="text-slate-800 dark:text-white">{{ session('error') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </div>

            <!-- Floating Chat Button -->
            <div id="floatingChatBtn" class="fixed bottom-6 right-6 z-50">
                <button class="relative flex items-center justify-center size-14 bg-primary hover:bg-primary/90 text-white rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-110">
                    <span class="material-symbols-outlined" style="font-size: 28px;">chat</span>
                    <span id="chatBadge" class="hidden absolute -top-1 -right-1 flex items-center justify-center min-w-[24px] h-6 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">0</span>
                </button>
            </div>

            <!-- Chat Popup Modal -->
            <div id="chatModal" class="hidden fixed bottom-24 right-6 z-50 w-96 h-[600px] rounded-xl shadow-2xl overflow-hidden">
                <div class="h-full flex flex-col bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border border-white/30 dark:border-white/10">
                    <!-- Chat Header -->
                    <div class="flex items-center justify-between p-4 border-b border-white/20 dark:border-white/10 bg-primary text-white">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined">chat_bubble</span>
                            <h3 class="font-bold text-lg">Tin nhắn</h3>
                        </div>
                        <button id="closeChatBtn" class="p-1 rounded-full hover:bg-white/20 transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <!-- Chat List -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-3">
                        <!-- Example Chat Items (Replace with dynamic data) -->
                        <a href="#" class="block p-3 rounded-lg hover:bg-white/50 dark:hover:bg-white/10 transition-colors">
                            <div class="flex gap-3">
                                <div class="relative shrink-0">
                                    <div class="size-12 rounded-full bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center text-white font-bold">
                                        LB
                                    </div>
                                    <div class="absolute bottom-0 right-0 size-3 bg-green-500 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="font-semibold text-slate-800 dark:text-white text-sm truncate">Lê Thị Bích</p>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">5 phút</span>
                                    </div>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 truncate">Chào bạn, sách này còn không?</p>
                                </div>
                                <div class="flex items-center">
                                    <span class="flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full">1</span>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="block p-3 rounded-lg hover:bg-white/50 dark:hover:bg-white/10 transition-colors">
                            <div class="flex gap-3">
                                <div class="size-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold shrink-0">
                                    TH
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="font-semibold text-slate-800 dark:text-white text-sm truncate">Trần Minh Hoàng</p>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">2 giờ</span>
                                    </div>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 truncate">Cảm ơn bạn nhiều nhé!</p>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="block p-3 rounded-lg hover:bg-white/50 dark:hover:bg-white/10 transition-colors">
                            <div class="flex gap-3">
                                <div class="size-12 rounded-full bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center text-white font-bold shrink-0">
                                    PD
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="font-semibold text-slate-800 dark:text-white text-sm truncate">Phạm Thị Dung</p>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">Hôm qua</span>
                                    </div>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 truncate">Bạn có ở gần cổng chính không?</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- View All Button -->
                    <div class="p-4 border-t border-white/20 dark:border-white/10">
                        <a href="/messages" class="block w-full py-2 px-4 bg-primary hover:bg-primary/90 text-white text-center rounded-lg font-medium transition-colors">
                            Xem tất cả tin nhắn
                        </a>
                    </div>
                </div>
            </div>

            <!-- Compose Message Modal -->
            <div id="composeMessageModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm">
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-2xl w-full max-w-lg mx-4" onclick="event.stopPropagation();">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Gửi tin nhắn</h3>
                        <button onclick="closeComposeModal()" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-400">close</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form id="composeMessageForm" class="p-6 space-y-4">
                        @csrf
                        <input type="hidden" id="composeRecipientId" name="recipient_id">
                        <input type="hidden" id="composeDocumentId" name="document_id">
                        
                        <!-- Recipient Info -->
                        <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                            <div id="composeRecipientAvatar" class="bg-gradient-to-br from-primary to-blue-600 rounded-full size-12 flex items-center justify-center text-white font-bold text-sm">
                            </div>
                            <div>
                                <p id="composeRecipientName" class="font-semibold text-slate-800 dark:text-white"></p>
                                <p id="composeRecipientEmail" class="text-sm text-slate-500 dark:text-slate-400"></p>
                            </div>
                        </div>

                        <!-- Document Context (if applicable) -->
                        <div id="composeDocumentContext" class="hidden flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">description</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-800 dark:text-white">Liên quan đến:</p>
                                <p id="composeDocumentName" class="text-sm text-slate-600 dark:text-slate-400"></p>
                            </div>
                        </div>

                        <!-- Message Input -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tin nhắn</label>
                            <textarea id="composeMessageInput" name="message" rows="5" required
                                class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-800 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="Nhập tin nhắn của bạn..."></textarea>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 pt-2">
                            <button type="button" onclick="closeComposeModal()" 
                                class="flex-1 px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors font-medium">
                                Hủy
                            </button>
                            <button type="submit" id="composeSendButton"
                                class="flex-1 px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 transition-colors font-medium">
                                Gửi tin nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-slate-900 text-white" id="contact">
                <div class="px-4 sm:px-6 lg:px-8 py-12">
                    <div class="layout-content-container mx-auto max-w-7xl">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                            <!-- Logo & Description -->
                            <div>
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="material-symbols-outlined text-white text-3xl">menu_book</span>
                                    <h5 class="text-xl font-bold">Trao Đổi Sách TVU</h5>
                                </div>
                                <p class="text-sm text-gray-400 mb-6">
                                    Nền tảng trao đổi sách và tài liệu chính thức của Đại học Trà Vinh.
                                </p>
                                <div class="flex gap-3">
                                    <a href="#" class="flex items-center justify-center size-9 rounded hover:bg-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                    <a href="#" class="flex items-center justify-center size-9 rounded hover:bg-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                    </a>
                                    <a href="#" class="flex items-center justify-center size-9 rounded hover:bg-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                                    </a>
                                    <a href="#" class="flex items-center justify-center size-9 rounded hover:bg-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- TÀI NGUYÊN -->
                            <div>
                                <h5 class="text-white font-bold mb-4 uppercase text-sm">TÀI NGUYÊN</h5>
                                <ul class="space-y-2 text-sm text-gray-400">
                                    <li><a href="#" class="hover:text-white transition-colors">Tài liệu học tập</a></li>
                                    <li><a href="#" class="hover:text-white transition-colors">Bài viết</a></li>
                                    <li><a href="#" class="hover:text-white transition-colors">Sự kiện</a></li>
                                </ul>
                            </div>
                            
                            <!-- HỖ TRỢ -->
                            <div>
                                <h5 class="text-white font-bold mb-4 uppercase text-sm">HỖ TRỢ</h5>
                                <ul class="space-y-2 text-sm text-gray-400">
                                    <li><a href="#" class="hover:text-white transition-colors">Trung tâm trợ giúp</a></li>
                                    <li><a href="#" class="hover:text-white transition-colors">Liên hệ</a></li>
                                    <li><a href="#" class="hover:text-white transition-colors">Câu hỏi thường gặp</a></li>
                                </ul>
                            </div>
                            
                            <!-- PHÁP LÝ -->
                            <div>
                                <h5 class="text-white font-bold mb-4 uppercase text-sm">PHÁP LÝ</h5>
                                <ul class="space-y-2 text-sm text-gray-400">
                                    <li><a href="#" class="hover:text-white transition-colors">Bảo mật</a></li>
                                    <li><a href="#" class="hover:text-white transition-colors">Điều khoản</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Copyright -->
                        <div class="border-t border-slate-800 mt-8 pt-6">
                            <p class="text-sm text-gray-400 text-center">
                                &copy; {{ date('Y') }} Trao Đổi Sách TVU, Đại học Trà Vinh. Mọi quyền được bảo lưu.
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Toggle user menu dropdown on click
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('userMenuButton');
            const menuDropdown = document.getElementById('userMenuDropdown');
            
            if (menuButton && menuDropdown) {
                // Toggle dropdown on button click
                menuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menuDropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!menuButton.contains(e.target) && !menuDropdown.contains(e.target)) {
                        menuDropdown.classList.add('hidden');
                    }
                });
                
                // Prevent dropdown from closing when clicking inside it
                menuDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Chat functionality
            const floatingChatBtn = document.getElementById('floatingChatBtn');
            const chatModal = document.getElementById('chatModal');
            const closeChatBtn = document.getElementById('closeChatBtn');
            const messagesNotificationBtn = document.getElementById('messagesNotificationBtn');
            
            if (floatingChatBtn && chatModal && closeChatBtn) {
                // Toggle chat modal
                floatingChatBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    chatModal.classList.toggle('hidden');
                    // Reset badge when opening chat
                    if (!chatModal.classList.contains('hidden')) {
                        resetChatBadge();
                    }
                });

                // Close chat modal
                closeChatBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    chatModal.classList.add('hidden');
                });

                // Close chat modal when clicking outside
                document.addEventListener('click', function(e) {
                    if (!floatingChatBtn.contains(e.target) && !chatModal.contains(e.target)) {
                        chatModal.classList.add('hidden');
                    }
                });

                // Prevent modal from closing when clicking inside
                chatModal.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Messages notification bell
            if (messagesNotificationBtn) {
                messagesNotificationBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    chatModal.classList.toggle('hidden');
                    // Reset badge when opening chat
                    if (!chatModal.classList.contains('hidden')) {
                        resetChatBadge();
                    }
                });
            }

            // Function to update message count
            function updateMessageCount(count) {
                const chatBadge = document.getElementById('chatBadge');
                const messagesBadge = document.getElementById('messagesBadge');
                
                if (count > 0) {
                    if (chatBadge) {
                        chatBadge.textContent = count;
                        chatBadge.classList.remove('hidden');
                    }
                    if (messagesBadge) {
                        messagesBadge.textContent = count;
                        messagesBadge.classList.remove('hidden');
                    }
                } else {
                    if (chatBadge) chatBadge.classList.add('hidden');
                    if (messagesBadge) messagesBadge.classList.add('hidden');
                }
            }

            // Function to reset chat badge
            function resetChatBadge() {
                const chatBadge = document.getElementById('chatBadge');
                const messagesBadge = document.getElementById('messagesBadge');
                if (chatBadge) chatBadge.classList.add('hidden');
                if (messagesBadge) messagesBadge.classList.add('hidden');
            }

            // Function to fetch unread messages count
            function fetchUnreadMessagesCount() {
                fetch('{{ route('messages.unread-count') }}', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.count !== undefined) {
                        updateMessageCount(data.count);
                    }
                })
                .catch(error => console.error('Error fetching unread messages:', error));
            }

            // Initialize message count on page load
            @auth
                fetchUnreadMessagesCount();
                // Poll for new messages every 30 seconds
                setInterval(fetchUnreadMessagesCount, 30000);
            @endauth

            // Simulate receiving a new message (for demo purposes)
            // Remove this in production and use WebSocket/Pusher instead
            window.simulateNewMessage = function() {
                const currentCount = parseInt(document.getElementById('chatBadge')?.textContent || '0');
                updateMessageCount(currentCount + 1);
            };
        });

        // WebSocket/Pusher integration for real-time updates
        // Uncomment and configure when Pusher/WebSocket is set up
        /*
        @auth
        if (typeof Pusher !== 'undefined') {
            const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
                cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
                encrypted: true
            });

            const channel = pusher.subscribe('user.{{ Auth::id() }}');
            channel.bind('new-message', function(data) {
                // Update message count
                const currentCount = parseInt(document.getElementById('chatBadge')?.textContent || '0');
                updateMessageCount(currentCount + 1);
                
                // Show notification (optional)
                if (Notification.permission === "granted") {
                    new Notification("Tin nhắn mới", {
                        body: data.message,
                        icon: "/img/logo.png"
                    });
                }
            });
        }
        @endauth
        */
    </script>

    <!-- Compose Message Modal Scripts -->
    <script>
        // Global function to open compose message modal
        window.openComposeMessageModal = function(recipientId, recipientName, recipientEmail, documentId = null, documentName = null) {
            const modal = document.getElementById('composeMessageModal');
            const recipientIdInput = document.getElementById('composeRecipientId');
            const documentIdInput = document.getElementById('composeDocumentId');
            const recipientAvatarEl = document.getElementById('composeRecipientAvatar');
            const recipientNameEl = document.getElementById('composeRecipientName');
            const recipientEmailEl = document.getElementById('composeRecipientEmail');
            const documentContext = document.getElementById('composeDocumentContext');
            const documentNameEl = document.getElementById('composeDocumentName');
            const messageInput = document.getElementById('composeMessageInput');

            // Set recipient data
            recipientIdInput.value = recipientId;
            recipientNameEl.textContent = recipientName;
            recipientEmailEl.textContent = recipientEmail;
            
            // Generate initials
            const initials = recipientName.split(' ').map(word => word[0]).slice(0, 2).join('').toUpperCase();
            recipientAvatarEl.textContent = initials;

            // Set document context if provided
            if (documentId && documentName) {
                documentIdInput.value = documentId;
                documentNameEl.textContent = documentName;
                documentContext.classList.remove('hidden');
            } else {
                documentIdInput.value = '';
                documentContext.classList.add('hidden');
            }

            // Clear previous message
            messageInput.value = '';

            // Show modal
            modal.classList.remove('hidden');
            
            // Focus on message input
            setTimeout(() => messageInput.focus(), 100);
        };

        // Close compose modal
        window.closeComposeModal = function() {
            const modal = document.getElementById('composeMessageModal');
            modal.classList.add('hidden');
        };

        // Close modal on backdrop click
        document.getElementById('composeMessageModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeComposeModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('composeMessageModal');
                if (!modal.classList.contains('hidden')) {
                    closeComposeModal();
                }
            }
        });

        // Handle compose message form submission
        document.getElementById('composeMessageForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();

            const sendButton = document.getElementById('composeSendButton');
            const messageInput = document.getElementById('composeMessageInput');
            const recipientId = document.getElementById('composeRecipientId').value;
            const documentId = document.getElementById('composeDocumentId').value;
            const message = messageInput.value.trim();

            if (!message) return;

            // Disable button
            sendButton.disabled = true;
            sendButton.textContent = 'Đang gửi...';

            try {
                const response = await fetch('/api/messages/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        recipient_id: recipientId,
                        message: message,
                        document_id: documentId || null
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Show success message
                    alert('✓ Tin nhắn đã được gửi thành công!');
                    
                    // Close modal
                    closeComposeModal();
                    
                    // Optionally redirect to messages page
                    if (confirm('Bạn có muốn xem tin nhắn không?')) {
                        window.location.href = '/messages?user_id=' + recipientId;
                    }
                } else {
                    alert('Không thể gửi tin nhắn. Vui lòng thử lại.');
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            } finally {
                // Re-enable button
                sendButton.disabled = false;
                sendButton.textContent = 'Gửi tin nhắn';
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

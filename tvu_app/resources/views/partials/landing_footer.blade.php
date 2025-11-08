<footer class="bg-gray-800">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-8 xl:col-span-1">
                <div class="flex items-center">
                    <i data-feather="book-open" class="h-8 w-8 text-white"></i>
                    <span class="ml-2 text-xl font-bold text-white">Trao Đổi Sách TVU</span>
                </div>
                <p class="text-gray-300 text-base">Nền tảng trao đổi sách và tài liệu chính thức của Đại học Trà Vinh.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white"><i data-feather="facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i data-feather="twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i data-feather="instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i data-feather="youtube"></i></a>
                </div>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Tài nguyên</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="{{ route('documents.index') }}" class="text-base text-gray-400 hover:text-white">Tài liệu học tập</a></li>
                            <li><a href="{{ route('blogs.index') }}" class="text-base text-gray-400 hover:text-white">Bài viết</a></li>
                            <li><a href="#" class="text-base text-gray-400 hover:text-white">Sự kiện</a></li>
                        </ul>
                    </div>
                    <div class="mt-12 md:mt-0">
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Hỗ trợ</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#" class="text-base text-gray-400 hover:text-white">Trung tâm trợ giúp</a></li>
                            <li><a href="{{ Route::has('contact') ? route('contact') : '#' }}" class="text-base text-gray-400 hover:text-white">Liên hệ</a></li>
                            <li><a href="#" class="text-base text-gray-400 hover:text-white">Câu hỏi thường gặp</a></li>
                        </ul>
                    </div>
                </div>
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Về chúng tôi</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#" class="text-base text-gray-400 hover:text-white">Giới thiệu</a></li>
                            <li><a href="#" class="text-base text-gray-400 hover:text-white">Đội ngũ</a></li>
                            <li><a href="#" class="text-base text-gray-400 hover:text-white">Tuyển dụng</a></li>
                        </ul>
                    </div>
                    <div class="mt-12 md:mt-0">
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Pháp lý</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#" class="text-base text-gray-400 hover:text-white">Bảo mật</a></li>
                            <li><a href="#" class="text-base text-gray-400 hover:text-white">Điều khoản</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 border-t border-gray-700 pt-8">
            <p class="text-base text-gray-400 text-center">&copy; {{ date('Y') }} Trao Đổi Sách TVU, Đại học Trà Vinh. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</footer>

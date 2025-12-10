@extends('layouts.app')

@section('title', 'Tìm Hiểu Thêm - TVU Docs Share')

@section('content')
<div class="w-full py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-blue-800 mb-8 text-center">Tìm Hiểu Thêm Về TVU Docs Share</h1>

        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-blue-700 mb-4 flex items-center">
                <i data-feather="info" class="mr-2"></i> Giới Thiệu
            </h2>
            <p class="text-gray-700 mb-4">
                TVU Docs Share là nền tảng chia sẻ tài liệu học tập được xây dựng bởi sinh viên, dành cho sinh viên Trường Đại học Trà Vinh.
            </p>
            <p class="text-gray-700 mb-4">
                Chúng tôi tin rằng việc chia sẻ kiến thức và tài liệu học tập sẽ giúp cộng đồng sinh viên TVU học tập hiệu quả hơn, tiết kiệm thời gian và nâng cao chất lượng học tập.
            </p>
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h3 class="text-lg font-semibold text-blue-800 mb-2 flex items-center">
                    <i data-feather="target" class="mr-2"></i> Mục Tiêu
                </h3>
                <ul class="list-disc pl-5 text-gray-700 space-y-1">
                    <li>Tạo kho tài liệu học tập phong phú, đa dạng</li>
                    <li>Kết nối sinh viên các khóa, các ngành học</li>
                    <li>Hỗ trợ sinh viên trong quá trình học tập và nghiên cứu</li>
                    <li>Xây dựng cộng đồng chia sẻ tri thức</li>
                </ul>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center">
                <i data-feather="repeat" class="mr-2"></i> Cách Thức Hoạt Động
            </h2>
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="bg-blue-100 text-blue-800 rounded-full w-10 h-10 flex items-center justify-center flex-shrink-0 mr-4">
                        <span class="font-bold">1</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Đăng ký tài khoản</h3>
                        <p class="text-gray-700">Sinh viên TVU đăng ký tài khoản bằng email trường (@sv.tvu.edu.vn) để xác thực.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-blue-100 text-blue-800 rounded-full w-10 h-10 flex items-center justify-center flex-shrink-0 mr-4">
                        <span class="font-bold">2</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Tải lên tài liệu</h3>
                        <p class="text-gray-700">Sinh viên có thể tải lên các tài liệu học tập như bài giảng, đề thi, tài liệu tham khảo.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-blue-100 text-blue-800 rounded-full w-10 h-10 flex items-center justify-center flex-shrink-0 mr-4">
                        <span class="font-bold">3</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Kiểm duyệt</h3>
                        <p class="text-gray-700">Ban quản trị sẽ kiểm duyệt nội dung trước khi đăng tải công khai.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-blue-100 text-blue-800 rounded-full w-10 h-10 flex items-center justify-center flex-shrink-0 mr-4">
                        <span class="font-bold">4</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Chia sẻ và học tập</h3>
                        <p class="text-gray-700">Tài liệu sau khi được duyệt sẽ hiển thị công khai cho tất cả sinh viên tham khảo.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center">
                <i data-feather="help-circle" class="mr-2"></i> Câu Hỏi Thường Gặp
            </h2>
            <div class="space-y-4">
                <div class="border-b border-gray-200 pb-4">
                    <button class="flex justify-between items-center w-full text-left font-semibold text-blue-800" onclick="toggleFAQ(this)">
                        <span>Ai có thể sử dụng TVU Docs Share?</span>
                        <i data-feather="chevron-down" class="transform transition-transform duration-200"></i>
                    </button>
                    <div class="hidden mt-2 text-gray-700">
                        Tất cả sinh viên đang theo học tại Trường Đại học Trà Vinh đều có thể sử dụng nền tảng này. Bạn cần đăng ký bằng email trường (@sv.tvu.edu.vn) để xác thực.
                    </div>
                </div>
                <div class="border-b border-gray-200 pb-4">
                    <button class="flex justify-between items-center w-full text-left font-semibold text-blue-800" onclick="toggleFAQ(this)">
                        <span>Tôi có thể đóng góp những loại tài liệu nào?</span>
                        <i data-feather="chevron-down" class="transform transition-transform duration-200"></i>
                    </button>
                    <div class="hidden mt-2 text-gray-700">
                        Bạn có thể đóng góp các tài liệu học tập như: bài giảng, slide, đề thi các năm, bài tập lớn, tài liệu tham khảo, sách chuyên ngành,... Tài liệu phải liên quan đến chương trình học tại TVU.
                    </div>
                </div>
                <div class="border-b border-gray-200 pb-4">
                    <button class="flex justify-between items-center w-full text-left font-semibold text-blue-800" onclick="toggleFAQ(this)">
                        <span>Tài liệu của tôi có được kiểm duyệt trước khi đăng không?</span>
                        <i data-feather="chevron-down" class="transform transition-transform duration-200"></i>
                    </button>
                    <div class="hidden mt-2 text-gray-700">
                        Có, tất cả tài liệu đều được kiểm duyệt bởi ban quản trị trước khi đăng tải công khai để đảm bảo chất lượng và phù hợp với tiêu chuẩn của nền tảng.
                    </div>
                </div>
                <div class="border-b border-gray-200 pb-4">
                    <button class="flex justify-between items-center w-full text-left font-semibold text-blue-800" onclick="toggleFAQ(this)">
                        <span>Tôi có thể tải tài liệu về miễn phí không?</span>
                        <i data-feather="chevron-down" class="transform transition-transform duration-200"></i>
                    </button>
                    <div class="hidden mt-2 text-gray-700">
                        Tất cả tài liệu trên TVU Docs Share đều miễn phí cho sinh viên TVU. Chúng tôi khuyến khích tinh thần chia sẻ trong cộng đồng sinh viên.
                    </div>
                </div>
                <div class="border-b border-gray-200 pb-4">
                    <button class="flex justify-between items-center w-full text-left font-semibold text-blue-800" onclick="toggleFAQ(this)">
                        <span>Làm thế nào để báo cáo tài liệu vi phạm?</span>
                        <i data-feather="chevron-down" class="transform transition-transform duration-200"></i>
                    </button>
                    <div class="hidden mt-2 text-gray-700">
                        Mỗi tài liệu đều có nút "Báo cáo" để bạn có thể thông báo với ban quản trị nếu phát hiện nội dung vi phạm. Bạn cũng có thể gửi email đến contact@tvudocs.edu.vn.
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center">
                <i data-feather="mail" class="mr-2"></i> Liên Hệ Với Chúng Tôi
            </h2>
            <form class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-700 mb-1">Họ và tên</label>
                    <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="subject" class="block text-gray-700 mb-1">Tiêu đề</label>
                    <input type="text" id="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="message" class="block text-gray-700 mb-1">Nội dung</label>
                    <textarea id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">Gửi liên hệ</button>
            </form>
        </div>
  </div>
</div>

@push('scripts')
<script>
    function toggleFAQ(button){
        const item = button.parentElement;
        const content = item.querySelector('div.hidden, div.mt-2');
        const icon = button.querySelector('i');
        if(content){ content.classList.toggle('hidden'); }
        if(icon){ icon.classList.toggle('rotate-180'); }
        if(window.feather){ window.feather.replace(); }
    }
</script>
@endpush

@endsection

<div class="py-10 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center mb-8">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Tài liệu phổ biến</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Tài liệu học tập nổi bật</p>
        </div>
        <div class="mt-6 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
            @php 
                $items = [
                    ['khoa' => 'Lý luận chính trị', 'title' => 'Kinh Tế Chính Trị MÁC - LÊNIN', 'desc' => 'Ghi chú đầy đủ các mục quan trọng.', 'price' => 'Miễn phí', 'img' => 'img/maclenin.jpg', 'doc_title' => 'Kinh Tế Chính Trị MÁC - LÊNIN'],
                    ['khoa' => 'Lý luận chính trị', 'title' => 'GIÁO TRÌNH LỊCH SỬ ĐẢNG CỘNG SẢN VIỆT NAM', 'desc' => 'Sách giáo khoa có đánh note đầy đủ với các khái niệm quan trọng', 'price' => '50,000 VND', 'img' => 'img/lichsudang.jpg', 'doc_title' => 'GIÁO TRÌNH LỊCH SỬ ĐẢNG CỘNG SẢN VIỆT NAM'],
                    ['khoa' => 'Công nghệ thông tin', 'title' => 'Tài liệu giảng dạy môn tin học ứng dụng tin học cơ bản', 'desc' => 'Có chú thích những phần quan trọng', 'price' => '30,000 VND', 'img' => 'img/tinhoccoban.jpg', 'doc_title' => 'Tài liệu giảng dạy môn tin học ứng dụng tin học cơ bản'],
                ];
            @endphp
            @foreach($items as $it)
            @php
                $doc = \App\Models\Document::where('ten_tai_lieu', $it['doc_title'])->first();
            @endphp
            <div class="flex flex-col rounded-lg shadow overflow-hidden bg-white">
                <div class="flex-shrink-0">
                    <img class="h-48 w-full object-cover" src="{{ asset($it['img']) }}" alt="{{ $it['title'] }}">
                </div>
                <div class="flex-1 p-6 flex flex-col justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-primary">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">{{ $it['khoa'] }}</span>
                        </p>
                        @if($doc)
                        <a href="{{ route('documents.show', $doc) }}" class="block mt-2">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $it['title'] }}</h3>
                            <p class="mt-3 text-base text-gray-500">{{ $it['desc'] }}</p>
                        </a>
                        @else
                        <div class="block mt-2">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $it['title'] }}</h3>
                            <p class="mt-3 text-base text-gray-500">{{ $it['desc'] }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <span class="text-xl font-bold text-gray-900">{{ $it['price'] }}</span>
                        @if($doc)
                        <a href="{{ route('documents.show', $doc) }}" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">Xem</a>
                        @else
                        <a href="{{ route('danh-muc') }}" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700">Xem</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>

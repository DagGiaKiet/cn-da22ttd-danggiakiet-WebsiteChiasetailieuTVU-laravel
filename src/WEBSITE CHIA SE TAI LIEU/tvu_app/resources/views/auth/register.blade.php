@extends('layouts.app')
@section('title','Đăng ký - Trao Đổi Sách TVU')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-xl bg-white rounded-2xl shadow p-8">
        <h1 class="text-3xl font-extrabold text-center text-gray-900">Tạo tài khoản mới</h1>
        <p class="mt-2 text-center text-sm text-gray-600">Sử dụng email sinh viên TVU (@st.tvu.edu.vn)</p>
        @if ($errors->any())
            <div class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="mt-6 space-y-4" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
                <input id="name_input" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Nguyễn Văn A" />
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email sinh viên</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="username@st.tvu.edu.vn" />
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mã sinh viên</label>
                <input name="ma_sv" value="{{ old('ma_sv') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('ma_sv') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="21D123456" />
                @error('ma_sv')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mã lớp</label>
                <input name="ma_lop" value="{{ old('ma_lop') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('ma_lop') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="DH21CS01" />
                @error('ma_lop')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hidden inputs that will receive selected labels to submit -->
            <input type="hidden" name="khoa" id="khoa_input" value="{{ old('khoa') }}">
            <input type="hidden" name="nganh" id="nganh_input" value="{{ old('nganh') }}">

            <div>
                <label class="block text-sm font-medium text-gray-700">Khoa</label>
                <select id="khoa_select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('khoa') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="">Chọn khoa</option>
                </select>
                @error('khoa')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Ngành</label>
                <select id="nganh_select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nganh') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" disabled>
                    <option value="">Chọn ngành</option>
                </select>
                @error('nganh')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                    <input name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Ít nhất 8 ký tự" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu</label>
                    <input name="password_confirmation" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Nhập lại mật khẩu" />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Ảnh thẻ (tùy chọn)</label>
                <input name="anh_the" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('anh_the') border-red-500 @enderror" />
                <p class="mt-1 text-xs text-gray-500">Hỗ trợ JPG/PNG, tối đa 2MB</p>
                @error('anh_the')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                </div>
                <label for="terms" class="ml-2 block text-sm text-gray-700">Tôi đồng ý với Điều khoản sử dụng và Chính sách bảo mật</label>
            </div>

            <div class="pt-2">
                <button class="w-full inline-flex items-center justify-center px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700">Tạo tài khoản</button>
            </div>
            <div class="text-center text-sm">
                <span class="text-gray-600">Đã có tài khoản? </span>
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Đăng nhập ngay</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function(){
    const apiBase = "{{ url('/public-api') }}";
    const $khoaSelect = document.getElementById('khoa_select');
    const $nganhSelect = document.getElementById('nganh_select');
        const $khoaInput = document.getElementById('khoa_input');
        const $nganhInput = document.getElementById('nganh_input');

        function clearSelect(sel, placeholder){
            sel.innerHTML = '';
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = placeholder;
            sel.appendChild(opt);
        }

        function loadKhoas(){
            fetch(apiBase + '/khoas')
                .then(r => r.json())
                .then(list => {
                    clearSelect($khoaSelect, 'Chọn khoa');
                    list.forEach(k => {
                        const opt = document.createElement('option');
                        opt.value = String(k.id);
                        opt.textContent = k.ten_khoa;
                        if($khoaInput.value && k.ten_khoa === $khoaInput.value){ opt.selected = true; }
                        $khoaSelect.appendChild(opt);
                    });
                    // Trigger change if old value exists
                    if($khoaSelect.value){ $khoaSelect.dispatchEvent(new Event('change')); }
                })
                .catch(() => {});
        }

        function loadNganhs(khoaId){
            $nganhSelect.disabled = true;
            clearSelect($nganhSelect, 'Chọn ngành');
            if(!khoaId){ return; }
            fetch(apiBase + '/nganhs?khoa_id=' + encodeURIComponent(khoaId))
                .then(r => r.json())
                .then(list => {
                    list.forEach(n => {
                        const opt = document.createElement('option');
                        opt.value = String(n.id);
                        opt.textContent = n.ten_nganh;
                        if($nganhInput.value && n.ten_nganh === $nganhInput.value){ opt.selected = true; }
                        $nganhSelect.appendChild(opt);
                    });
                    $nganhSelect.disabled = false;
                    // autofocus ngành sau khi tải
                    $nganhSelect.focus();
                    if($nganhSelect.value){ $nganhSelect.dispatchEvent(new Event('change')); }
                })
                .catch(() => {});
        }

        $khoaSelect.addEventListener('change', function(){
            // set hidden input to selected label
            const label = this.options[this.selectedIndex]?.textContent || '';
            $khoaInput.value = label || '';
            // reset lower levels
            clearSelect($nganhSelect, 'Chọn ngành');
            $nganhInput.value = '';
            $nganhSelect.disabled = true;
            if(this.value){ loadNganhs(this.value); }
        });

        $nganhSelect.addEventListener('change', function(){
            const label = this.options[this.selectedIndex]?.textContent || '';
            $nganhInput.value = label || '';
            // focus vào họ tên để người dùng tiếp tục
            const nameInput = document.getElementById('name_input');
            if(nameInput){ nameInput.focus(); }
        });

        // Init
        loadKhoas();
    })();
</script>
@endpush

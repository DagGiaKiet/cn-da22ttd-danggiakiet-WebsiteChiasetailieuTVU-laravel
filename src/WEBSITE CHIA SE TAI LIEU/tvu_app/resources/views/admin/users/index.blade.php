@extends('layouts.admin')
@section('title','Admin - Quản lý tài khoản')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Quản lý tài khoản sinh viên</h2>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Chỉ email @st.tvu.edu.vn được phép đăng ký</p>
    </div>
    <div class="px-6 py-4">
      @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4 border border-green-200 text-green-800">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200 text-red-800">{{ session('error') }}</div>
      @endif
      <div class="flex justify-between items-center mb-4">
        <div class="relative">
          <input type="text" id="user-search" placeholder="Tìm kiếm sinh viên..." class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
          <i data-feather="search" class="absolute left-3 top-2.5 text-gray-400 dark:text-gray-500"></i>
        </div>
        <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium hover:bg-primary-700">Thêm tài khoản</a>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Họ tên</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Thao tác</th>
            </tr>
          </thead>
          <tbody id="user-table-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
             @include('admin.users.table_rows')
          </tbody>
        </table>
      </div>
      <div class="mt-4">{{ $users->links() }}</div>
    </div>
  </div>
</div>

<!-- User Info Modal -->
<div id="userInfoModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div id="userInfoOverlay" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0" onclick="closeUserInfo()"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div id="userInfoPanel" class="inline-block align-bottom bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-white/20 dark:border-gray-700/50 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 ease-out opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="px-6 pt-6 pb-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-[24px]">person_search</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Thông tin chi tiết</h3>
        </div>
        <div id="userInfoContent" class="space-y-4">
             <p class="text-gray-500 text-sm italic">Đang tải...</p>
        </div>
      </div>
      <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex flex-row-reverse">
        <button type="button" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5" onclick="closeUserInfo()">
            Đóng
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div id="resetPasswordOverlay" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0" onclick="closeResetPassword()"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
    <div id="resetPasswordPanel" class="inline-block align-bottom bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-white/20 dark:border-gray-700/50 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 ease-out opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <form id="resetPasswordForm" method="POST" action="">
        @csrf
        @method('PATCH')
        <div class="px-6 pt-6 pb-6">
          <div class="flex items-center gap-3 mb-6">
              <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full text-blue-600 dark:text-blue-400">
                   <span class="material-symbols-outlined text-[24px]">lock_reset</span>
              </div>
              <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                  Reset mật khẩu: <span id="resetUserName" class="text-blue-600 dark:text-blue-400"></span>
              </h3>
          </div>
          
          <div class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Mật khẩu mới</label>
                <input type="password" name="password" required 
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white placeholder-gray-400 transition-all shadow-sm"
                       placeholder="Nhập mật khẩu mới..." />
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" required 
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white placeholder-gray-400 transition-all shadow-sm"
                       placeholder="Nhập lại mật khẩu..." />
            </div>
          </div>
        </div>
        <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex flex-row-reverse gap-3">
            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                Xác nhận đổi
            </button>
            <button type="button" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center rounded-xl px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-all" onclick="closeResetPassword()">
                Hủy
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Toggle Status Confirmation Modal -->
<div id="toggleStatusModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div id="toggleStatusOverlay" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0" onclick="closeToggleStatus()"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
    <div id="toggleStatusPanel" class="inline-block align-bottom bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-white/20 dark:border-gray-700/50 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 ease-out opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="px-6 pt-6 pb-6">
        <div class="flex items-center gap-4">
            <div id="statusIconBg" class="p-3 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                <span id="statusIcon" class="material-symbols-outlined text-[24px]">lock</span>
            </div>
            <div>
                 <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-1" id="statusTitle">Xác nhận khóa</h3>
                 <p class="text-sm text-gray-500 dark:text-gray-400" id="statusMessage">Bạn có chắc muốn khóa tài khoản này?</p>
            </div>
        </div>
      </div>
      <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex flex-row-reverse gap-3">
          <form id="toggleStatusForm" method="POST" action="">
             @csrf
             @method('PATCH')
             <button type="submit" id="statusConfirmBtn" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5">
                 Xác nhận
             </button>
          </form>
          <button type="button" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center rounded-xl px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-all" onclick="closeToggleStatus()">
              Hủy
          </button>
      </div>
    </div>
  </div>
</div>

<script>
    // Helper function for modal animations
    function openModalAnimation(modalId, overlayId, panelId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById(overlayId);
        const panel = document.getElementById(panelId);

        modal.classList.remove('hidden');
        
        // Use double requestAnimationFrame to ensure browser has processed 'block' display
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                // Overlay enter
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
                
                // Panel enter
                panel.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            });
        });
    }

    function closeModalAnimation(modalId, overlayId, panelId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById(overlayId);
        const panel = document.getElementById(panelId);

        // Overlay leave
        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0');
        
        // Panel leave
        panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
        panel.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');

        // Wait for transition duration (300ms) before hiding
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function showUserInfo(userId) {
        openModalAnimation('userInfoModal', 'userInfoOverlay', 'userInfoPanel');
        const content = document.getElementById('userInfoContent');
        content.innerHTML = '<p class="text-gray-500 text-sm italic">Đang tải thông tin...</p>';
        
        // Fetch user info
        fetch(`/admin/users/${userId}`)
            .then(res => res.json())
            .then(data => {
                const statusColor = data.status === 'active' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                const statusText = data.status === 'active' ? 'Hoạt động' : 'Đã khóa';
                const createdDate = new Date(data.created_at).toLocaleDateString('vi-VN');
                
                // Student ID Card Image logic
                const anhTheHtml = data.anh_the_url 
                    ? `<div class="col-span-1 mt-1 p-3 rounded-xl bg-gray-50/80 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-600/50">
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 block flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">badge</span> Ảnh thẻ sinh viên</span>
                        <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800">
                            <img src="${data.anh_the_url}" alt="Ảnh thẻ sinh viên" class="w-full h-48 object-contain cursor-pointer transition-transform hover:scale-105" onclick="window.open(this.src, '_blank')" title="Nhấn để xem ảnh gốc">
                        </div>
                       </div>` 
                    : '';

                content.innerHTML = `
                    <div class="grid grid-cols-1 gap-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col p-3 rounded-xl bg-gray-50/80 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-600/50">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Họ tên</span>
                                <span class="text-base text-gray-900 dark:text-white font-bold truncate" title="${data.name}">${data.name}</span>
                            </div>
                             <div class="flex flex-col p-3 rounded-xl bg-gray-50/80 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-600/50">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Email</span>
                                <span class="text-base text-gray-900 dark:text-white font-medium truncate" title="${data.email}">${data.email}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                             <div class="flex flex-col p-3 rounded-xl bg-gray-50/80 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-600/50">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Quyền hạn</span>
                                <span class="text-sm text-gray-900 dark:text-white font-bold uppercase inline-flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px] text-indigo-500">${data.role === 'admin' ? 'verified_user' : 'school'}</span>
                                    ${data.role}
                                </span>
                            </div>
                             <div class="flex flex-col p-3 rounded-xl bg-gray-50/80 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-600/50">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Trạng thái</span>
                                <span class="text-sm font-bold ${statusColor} inline-flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px]">${data.status === 'active' ? 'check_circle' : 'block'}</span>
                                    ${statusText}
                                </span>
                            </div>
                        </div>
                        
                         <div class="flex flex-col p-3 rounded-xl bg-gray-50/80 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-600/50">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Ngày tham gia</span>
                            <span class="text-sm text-gray-700 dark:text-gray-300 font-medium inline-flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px] text-gray-400">calendar_month</span>
                                ${createdDate}
                            </span>
                        </div>

                        ${anhTheHtml}
                    </div>
                `;
            })
            .catch(err => {
                content.innerHTML = '<p class="text-red-500 text-sm">Không thể tải thông tin.</p>';
            });
    }

    function closeUserInfo() {
        closeModalAnimation('userInfoModal', 'userInfoOverlay', 'userInfoPanel');
    }

    function showResetPassword(userId, userName) {
        document.getElementById('resetUserName').innerText = userName;
        const form = document.getElementById('resetPasswordForm');
        form.action = `/admin/users/${userId}/reset-password`;
        openModalAnimation('resetPasswordModal', 'resetPasswordOverlay', 'resetPasswordPanel');
    }

    function closeResetPassword() {
         closeModalAnimation('resetPasswordModal', 'resetPasswordOverlay', 'resetPasswordPanel');
    }

    // Toggle Status Modal Functions
    function showToggleStatus(url, status, userName) {
        const modal = document.getElementById('toggleStatusModal');
        const form = document.getElementById('toggleStatusForm');
        const title = document.getElementById('statusTitle');
        const message = document.getElementById('statusMessage');
        const icon = document.getElementById('statusIcon');
        const iconBg = document.getElementById('statusIconBg');
        const confirmBtn = document.getElementById('statusConfirmBtn');

        form.action = url;
        
        if (status === 'locked') {
            // Case: User is currently locked -> Action is UNLOCK
            title.innerText = 'Mở khóa tài khoản';
            message.innerHTML = `Bạn có chắc muốn mở khóa cho tài khoản <span class="font-bold text-gray-900 dark:text-white">${userName}</span>?`;
            icon.innerText = 'lock_open';
            
            // Green theme for unlock
            iconBg.className = 'p-3 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400';
            confirmBtn.className = 'w-full sm:w-auto inline-flex justify-center items-center rounded-xl px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold shadow-lg shadow-green-500/30 transition-all transform hover:-translate-y-0.5';
            confirmBtn.innerText = 'Mở khóa ngay';
        } else {
            // Case: User is currently active -> Action is LOCK
            title.innerText = 'Khóa tài khoản';
            message.innerHTML = `Bạn có chắc muốn khóa tài khoản <span class="font-bold text-gray-900 dark:text-white">${userName}</span>?`;
            icon.innerText = 'lock';
            
            // Red theme for lock
            iconBg.className = 'p-3 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400';
            confirmBtn.className = 'w-full sm:w-auto inline-flex justify-center items-center rounded-xl px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5';
            confirmBtn.innerText = 'Khóa ngay';
        }

        openModalAnimation('toggleStatusModal', 'toggleStatusOverlay', 'toggleStatusPanel');
    }

    function closeToggleStatus() {
        closeModalAnimation('toggleStatusModal', 'toggleStatusOverlay', 'toggleStatusPanel');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('user-search');
        const tableBody = document.getElementById('user-table-body');
        let searchTimeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('admin.users.index') }}?search=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    tableBody.innerHTML = html;
                    if(window.feather) window.feather.replace();
                })
                .catch(err => console.error(err));
            }, 300);
        });
    });
</script>
@endsection

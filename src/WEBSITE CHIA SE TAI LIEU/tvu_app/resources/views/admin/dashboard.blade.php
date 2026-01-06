@extends('layouts.admin')
@section('title','Trang quản trị - TVU')

@section('content')
<div class="max-w-7xl mx-auto">
  <!-- Header search and actions -->
  <div class="bg-gradient-to-r from-indigo-500 to-blue-600 rounded-2xl p-6 text-white shadow mb-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
      <div class="flex items-center gap-3">
        <i data-feather="grid" class="w-6 h-6"></i>
        <h1 class="text-2xl font-bold">Bảng điều khiển</h1>
      </div>
      <div class="flex-1 min-w-[240px] max-w-xl">
        <div class="relative group">
          <input id="globalSearchInput" autocomplete="off" class="w-full rounded-xl pl-11 pr-4 py-2 text-gray-800 border-none focus:ring-2 focus:ring-white/50 bg-white/90 backdrop-blur transition-all" placeholder="Tìm kiếm (Người dùng, Đơn hàng, Tài liệu...)" />
          <i data-feather="search" class="w-5 h-5 text-gray-400 absolute left-3 top-2.5 pointer-events-none"></i>
          
          <!-- Search Results Dropdown -->
          <div id="globalSearchResults" class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden hidden z-50">
             <div class="p-2 text-sm text-gray-500 text-center" id="searchLoading" style="display:none;">Đang tìm kiếm...</div>
             <div id="searchResultsList" class="max-h-[70vh] overflow-y-auto"></div>
          </div>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('home') }}" class="bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2 rounded-xl">Xem trang chủ</a>
      </div>
    </div>
  </div>

  <!-- KPI Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <a href="{{ route('admin.orders.index') }}" class="block text-inherit hover:underline decoration-0">
    <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-5 hover:bg-gray-50 dark:hover:bg-gray-750 cursor-pointer h-full">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500 dark:text-gray-400">Doanh thu</div>
          <div class="text-3xl font-bold text-gray-900 dark:text-white" id="stat-revenue">{{ number_format($revenue, 0, ',', '.') }} đ</div>
        </div>
        <span class="text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 px-2 py-1 rounded">Hôm nay</span>
      </div>
      <div class="mt-3 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded">
        <div class="h-2 bg-indigo-500 rounded" style="width: 95%"></div>
      </div>
    </div>
    </a>
  <a href="{{ route('admin.orders.index') }}" class="block text-inherit hover:underline decoration-0">
  <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-5 hover:bg-gray-50 dark:hover:bg-gray-750 cursor-pointer h-full">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500 dark:text-gray-400">Đơn hàng</div>
          <div class="text-3xl font-bold text-gray-900 dark:text-white" id="stat-orders">{{ number_format($ordersCount) }}</div>
        </div>
        <span class="text-xs bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 px-2 py-1 rounded">Tuần này</span>
      </div>
      <div class="mt-3 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded">
        <div class="h-2 bg-yellow-500 rounded" style="width: 65%"></div>
      </div>
    </div>
    </a>
  <a href="{{ route('admin.users.index') }}" class="block text-inherit hover:underline decoration-0">
  <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-5 hover:bg-gray-50 dark:hover:bg-gray-750 cursor-pointer h-full">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500 dark:text-gray-400">Khách hàng</div>
          <div class="text-3xl font-bold text-gray-900 dark:text-white" id="stat-leads">{{ number_format($leads) }}</div>
        </div>
        <span class="text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 px-2 py-1 rounded">Tháng này</span>
      </div>
      <div class="mt-3 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded">
        <div class="h-2 bg-green-500 rounded" style="width: 75%"></div>
      </div>
    </div>
    </a>
  <a href="{{ route('admin.orders.index') }}" class="block text-inherit hover:underline decoration-0">
  <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-5 hover:bg-gray-50 dark:hover:bg-gray-750 cursor-pointer h-full">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500 dark:text-gray-400">Tỷ lệ chuyển đổi</div>
          <div class="text-3xl font-bold text-gray-900 dark:text-white" id="stat-conversion">{{ $conversionRate }} %</div>
        </div>
        <span class="text-xs bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-200 px-2 py-1 rounded">Tổng</span>
      </div>
      <div class="mt-3 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded">
        <div class="h-2 bg-purple-500 rounded" style="width: {{ $conversionRate }}%"></div>
      </div>
    </div>
    </a>
    <a href="{{ route('admin.contacts.index') }}" class="block text-inherit hover:underline decoration-0">
    <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-5 hover:bg-gray-50 dark:hover:bg-gray-750 cursor-pointer h-full">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500 dark:text-gray-400">Liên hệ</div>
          <div class="text-3xl font-bold text-gray-900 dark:text-white" id="stat-contacts">{{ number_format($contactsCount) }}</div>
        </div>
        <span class="text-xs bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-200 px-2 py-1 rounded">Mới</span>
      </div>
      <div class="mt-3 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded">
        <div class="h-2 bg-pink-500 rounded" style="width: 100%"></div>
      </div>
    </div>
    </a>
  </div>

  <!-- Charts and stats -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
  <div class="admin-card lg:col-span-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lịch sử thanh toán</h3>
        <button class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300"><i data-feather="more-horizontal"></i></button>
      </div>
      <canvas id="ordersRevenueChart" height="120"></canvas>
    </div>
  <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tóm tắt</h3>
      </div>
      <ul class="space-y-3">
                <li class="flex items-center justify-between"><span class="text-gray-600 dark:text-gray-400">Người dùng</span> <span class="font-semibold text-gray-900 dark:text-white">{{ number_format((int) $users) }}</span></li>
                <li class="flex items-center justify-between"><span class="text-gray-600 dark:text-gray-400">Tài liệu</span> <span class="font-semibold text-gray-900 dark:text-white">{{ number_format((int) $documents) }}</span></li>
                <li class="flex items-center justify-between"><span class="text-gray-600 dark:text-gray-400">Bài blog</span> <span class="font-semibold text-gray-900 dark:text-white">{{ number_format((int) $blogs) }}</span></li>
                <li class="flex items-center justify-between"><span class="text-gray-600 dark:text-gray-400">Đơn hàng</span> <span class="font-semibold text-gray-900 dark:text-white">{{ number_format((int) $ordersCount) }}</span></li>
      </ul>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="admin-card lg:col-span-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hoạt động gần đây</h3>
      </div>
      <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($recentOrders as $o)
          <div class="py-3 flex items-center justify-between">
            <div>
              <div class="font-medium text-gray-900 dark:text-white">{{ $o->document->ten_tai_lieu ?? 'Tài liệu' }}</div>
              <div class="text-sm text-gray-500 dark:text-gray-400">{{ $o->user->name ?? 'Người dùng' }} • {{ $o->created_at->diffForHumans() }}</div>
            </div>
            <div class="text-right">
              <div class="font-semibold text-gray-900 dark:text-white">{{ number_format((int)($o->document->gia ?? 0), 0, ',', '.') }} đ</div>
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                @class([
                  'bg-yellow-100 text-yellow-800' => $o->trang_thai === 'pending',
                  'bg-blue-100 text-blue-800' => $o->trang_thai === 'dang_giao',
                  'bg-green-100 text-green-800' => $o->trang_thai === 'da_nhan',
                  'bg-red-100 text-red-800' => $o->trang_thai === 'huy',
                ])">{{ $o->trang_thai }}</span>
            </div>
          </div>
        @empty
          <div class="py-6 text-center text-gray-500 dark:text-gray-400">Chưa có đơn hàng nào.</div>
        @endforelse
      </div>
    </div>
  <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kênh xã hội</h3>
      </div>
      <div class="space-y-4">
        <div class="flex items-center justify-between"><div class="flex items-center gap-2"><i data-feather="facebook" class="text-blue-600"></i><span class="text-gray-700 dark:text-gray-300">Facebook</span></div><span class="font-semibold text-gray-900 dark:text-white">35000</span></div>
        <div class="flex items-center justify-between"><div class="flex items-center gap-2"><i data-feather="twitter" class="text-sky-500"></i><span class="text-gray-700 dark:text-gray-300">Twitter</span></div><span class="font-semibold text-gray-900 dark:text-white">2500</span></div>
        <div class="flex items-center justify-between"><div class="flex items-center gap-2"><i data-feather="youtube" class="text-red-500"></i><span class="text-gray-700 dark:text-gray-300">YouTube</span></div><span class="font-semibold text-gray-900 dark:text-white">1.7M</span></div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  const labels = @json($labels);
  const ordersSeries = @json($ordersSeries);
  const revenueSeries = @json($revenueSeries);

  let chartInstance = null;
  function isDark(){
    const html = document.documentElement;
    return html.classList.contains('dark') || html.getAttribute('data-theme') === 'dark';
  }
  function buildChartOptions(){
    const dark = isDark();
    const tick = dark ? '#9CA3AF' : '#6B7280';
    const grid = dark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
    return {
      type: 'bar',
      data: {
        labels,
        datasets: [
          {
            type: 'bar',
            label: 'Đơn hàng',
            data: ordersSeries,
            backgroundColor: dark ? 'rgba(59, 130, 246, 0.55)' : 'rgba(59, 130, 246, 0.6)',
            borderColor: 'rgb(59, 130, 246)'
          },
          {
            type: 'line',
            label: 'Doanh thu (đ)',
            data: revenueSeries,
            borderColor: dark ? 'rgb(129, 140, 248)' : 'rgb(99, 102, 241)',
            backgroundColor: dark ? 'rgba(129, 140, 248, 0.25)' : 'rgba(99, 102, 241, 0.25)',
            tension: 0.3,
            yAxisID: 'y1'
          }
        ]
      },
      options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        stacked: false,
        plugins: { legend: { labels: { color: tick } } },
        scales: {
          x: { ticks: { color: tick }, grid: { color: grid } },
          y: { beginAtZero: true, ticks: { color: tick }, grid: { color: grid }, title: { display: true, text: 'Số đơn', color: tick } },
          y1: { beginAtZero: true, position: 'right', ticks: { color: tick }, grid: { drawOnChartArea:false, color: grid }, title: { display: true, text: 'VNĐ', color: tick } }
        }
      }
    };
  }

  function mountChart(){
    const ctx = document.getElementById('ordersRevenueChart');
    if (!ctx) return;
    if (chartInstance) { chartInstance.destroy(); chartInstance = null; }
    chartInstance = new Chart(ctx, buildChartOptions());
  }

  // init and react to theme change
  mountChart();
  window.addEventListener('theme:changed', mountChart);
  if (window.feather) { window.feather.replace(); }

  // --- Global Search Logic ---
  const searchInput = document.getElementById('globalSearchInput');
  const resultsContainer = document.getElementById('globalSearchResults');
  let searchTimeout = null;

  if(searchInput && resultsContainer) {
      searchInput.addEventListener('input', function() {
          clearTimeout(searchTimeout);
          const query = this.value.trim();
          
          if(query.length < 2) {
              resultsContainer.classList.add('hidden');
              resultsContainer.innerHTML = '';
              return;
          }

          searchTimeout = setTimeout(() => {
              fetch(`{{ route('admin.global-search') }}?query=${encodeURIComponent(query)}`)
                  .then(response => response.json())
                  .then(data => {
                      renderSearchResults(data);
                  })
                  .catch(err => console.error(err));
          }, 300);
      });

      // Hide results when clicking outside
      document.addEventListener('click', function(e) {
          if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
              resultsContainer.classList.add('hidden');
          }
      });
      
      // Show results again if input focused and has value
       searchInput.addEventListener('focus', function() {
           if(this.value.trim().length >= 2 && resultsContainer.innerHTML !== "") {
               resultsContainer.classList.remove('hidden');
           }
       });
  }

  function renderSearchResults(data) {
      if(data.length === 0) {
          resultsContainer.innerHTML = '<div class="p-3 text-gray-500 text-sm">Không tìm thấy kết quả</div>';
          resultsContainer.classList.remove('hidden');
          return;
      }

      let html = '';
      data.forEach(item => {
          html += `
              <a href="${item.url}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border-b border-gray-100 dark:border-gray-700 last:border-0 block">
                  <span class="text-blue-500 mr-2"><i data-feather="${item.icon}"></i></span>
                  <div>
                      <div class="font-medium text-sm text-gray-800 dark:text-gray-200">${item.title}</div>
                      <span class="text-xs text-gray-400">${item.subtitle}</span>
                  </div>
              </a>
          `;
      });
      
      resultsContainer.innerHTML = html;
      resultsContainer.classList.remove('hidden');
      if (window.feather) { window.feather.replace(); }
  }

  // Realtime Stats Polling
  setInterval(function() {
      fetch('{{ route("admin.dashboard.stats") }}')
          .then(response => response.json())
          .then(data => {
              if(data) {
                  const r = document.getElementById('stat-revenue');
                  const o = document.getElementById('stat-orders');
                  const l = document.getElementById('stat-leads');
                  const c = document.getElementById('stat-conversion');
                  const cnt = document.getElementById('stat-contacts');

                  if(r) r.innerText = data.revenue;
                  if(o) o.innerText = data.orders;
                  if(l) l.innerText = data.leads;
                  if(c) c.innerText = data.conversionRate;
                  if(cnt) cnt.innerText = data.contacts;
              }
          })
          .catch(err => console.error('Stats polling error', err));
  }, 5000); // 5 seconds
</script>
@endpush
@endsection


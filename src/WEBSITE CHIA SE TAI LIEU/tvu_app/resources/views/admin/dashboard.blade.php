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
        <div class="relative">
          <input class="w-full rounded-xl pl-11 pr-4 py-2 text-gray-800" placeholder="Tìm kiếm..." />
          <i data-feather="search" class="w-5 h-5 text-gray-400 absolute left-3 top-2.5"></i>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('home') }}" class="bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2 rounded-xl">Xem trang chủ</a>
      </div>
    </div>
  </div>

  <!-- KPI Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-5">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500 dark:text-gray-400">Revenue</div>
          <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($revenue, 0, ',', '.') }} đ</div>
        </div>
        <span class="text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 px-2 py-1 rounded">Hôm nay</span>
      </div>
      <div class="mt-3 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded">
        <div class="h-2 bg-indigo-500 rounded" style="width: 95%"></div>
      </div>
    </div>
  <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-5">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500 dark:text-gray-400">Orders</div>
          <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($ordersCount) }}</div>
        </div>
        <span class="text-xs bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 px-2 py-1 rounded">Tuần này</span>
      </div>
      <div class="mt-3 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded">
        <div class="h-2 bg-yellow-500 rounded" style="width: 65%"></div>
      </div>
    </div>
  <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-5">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500 dark:text-gray-400">Leads</div>
          <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($leads) }}</div>
        </div>
        <span class="text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 px-2 py-1 rounded">Tháng này</span>
      </div>
      <div class="mt-3 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded">
        <div class="h-2 bg-green-500 rounded" style="width: 75%"></div>
      </div>
    </div>
  <div class="admin-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-5">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm text-gray-500 dark:text-gray-400">Lead Conversion Rate</div>
          <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $conversionRate }} %</div>
        </div>
        <span class="text-xs bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-200 px-2 py-1 rounded">Tổng</span>
      </div>
      <div class="mt-3 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded">
        <div class="h-2 bg-purple-500 rounded" style="width: {{ $conversionRate }}%"></div>
      </div>
    </div>
  </div>

  <!-- Charts and stats -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
  <div class="admin-card lg:col-span-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-colors rounded-xl shadow p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Payment History</h3>
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
            label: 'Orders',
            data: ordersSeries,
            backgroundColor: dark ? 'rgba(59, 130, 246, 0.55)' : 'rgba(59, 130, 246, 0.6)',
            borderColor: 'rgb(59, 130, 246)'
          },
          {
            type: 'line',
            label: 'Revenue (đ)',
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
          y: { beginAtZero: true, ticks: { color: tick }, grid: { color: grid }, title: { display: true, text: 'Orders', color: tick } },
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
</script>
@endpush
@endsection


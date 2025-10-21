@extends('layouts.app')
@section('title','Danh mục - Trao Đổi Sách TVU')
@section('content')
<div id="category-search" class="py-6"
  data-api-khoas="/public-api/khoas"
  data-api-nganhs="/public-api/nganhs"
  data-api-mons="/public-api/mons"
  data-api-documents="/public-api/documents"
  data-route-document="/documents"
  data-fallback-img="/img/maclenin.jpg">
  <div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Tìm kiếm tài liệu theo danh mục</h1>
  <div id="statusMsg" class="hidden mb-4 text-sm"></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Khoa</label>
        <select id="faculty" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md border">
          <option value="">Chọn khoa</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Ngành</label>
        <select id="major" disabled class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md border bg-gray-100">
          <option value="">Chọn ngành</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Môn học</label>
        <select id="subject" disabled class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md border bg-gray-100">
          <option value="">Chọn môn học</option>
        </select>
      </div>
    </div>
    <button id="searchBtn" disabled class="w-full md:w-auto px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed">Tìm kiếm</button>

    <div id="results" class="mt-8 hidden">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Kết quả tìm kiếm</h2>
      <div class="space-y-4" id="resultsContainer"></div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  if (window.feather) window.feather.replace();

  const root = document.getElementById('category-search');
  const API = {
    khoas: root.dataset.apiKhoas,
    nganhs: root.dataset.apiNganhs,
    mons: root.dataset.apiMons,
    documents: root.dataset.apiDocuments,
  };
  const ROUTES = {
    documentShow: root.dataset.routeDocument,
  };
  const FALLBACK_IMG = root.dataset.fallbackImg;

  const selKhoa = document.getElementById('faculty');
  const selNganh = document.getElementById('major');
  const selMon = document.getElementById('subject');
  const btnSearch = document.getElementById('searchBtn');
  const results = document.getElementById('results');
  const resultsContainer = document.getElementById('resultsContainer');
  const statusMsg = document.getElementById('statusMsg');

  function setStatus(message, type = 'info') {
    if (!message) { statusMsg.classList.add('hidden'); statusMsg.textContent=''; return; }
    statusMsg.classList.remove('hidden');
    statusMsg.textContent = message;
    statusMsg.className = 'mb-4 text-sm ' + (type === 'error' ? 'text-red-600' : 'text-gray-600');
  }

  // Fetch Khoas
  fetch(API.khoas)
    .then(r => r.json()).then(data => {
      setStatus('');
      data.forEach(k => {
        const opt = document.createElement('option');
        opt.value = k.id; opt.textContent = k.ten_khoa; selKhoa.appendChild(opt);
      });
    }).catch(err => { console.error(err); setStatus('Không tải được danh sách Khoa. Vui lòng thử lại.', 'error'); });

  selKhoa.addEventListener('change', () => {
    selNganh.innerHTML = '<option value="">Chọn ngành</option>';
    selNganh.disabled = !selKhoa.value; selNganh.classList.toggle('bg-gray-100', !selKhoa.value);
    selMon.innerHTML = '<option value="">Chọn môn học</option>';
    selMon.disabled = true; selMon.classList.add('bg-gray-100');
    btnSearch.disabled = true;
    if (!selKhoa.value) return;
    fetch(`${API.nganhs}?khoa_id=${encodeURIComponent(selKhoa.value)}`)
      .then(r => r.json()).then(data => {
        data.forEach(n => {
          const opt = document.createElement('option');
          opt.value = n.id; opt.textContent = n.ten_nganh; selNganh.appendChild(opt);
        });
      }).catch(err => { console.error(err); setStatus('Không tải được danh sách Ngành.', 'error'); });
  });

  selNganh.addEventListener('change', () => {
    selMon.innerHTML = '<option value="">Chọn môn học</option>';
    selMon.disabled = !selNganh.value; selMon.classList.toggle('bg-gray-100', !selNganh.value);
    btnSearch.disabled = true;
    if (!selNganh.value) return;
    fetch(`${API.mons}?nganh_id=${encodeURIComponent(selNganh.value)}`)
      .then(r => r.json()).then(data => {
        data.forEach(m => {
          const opt = document.createElement('option');
          opt.value = m.id; opt.textContent = m.ten_mon; selMon.appendChild(opt);
        });
      }).catch(err => { console.error(err); setStatus('Không tải được danh sách Môn học.', 'error'); });
  });

  selMon.addEventListener('change', () => {
    btnSearch.disabled = !selMon.value;
  });

  btnSearch.addEventListener('click', () => {
    fetch(`${API.documents}?mon_id=${encodeURIComponent(selMon.value)}`)
      .then(r => r.json()).then(list => {
        resultsContainer.innerHTML = '';
        list.forEach(doc => {
          const el = document.createElement('div');
          el.className = 'bg-gray-50 p-4 rounded-lg flex flex-col md:flex-row items-start md:items-center gap-4';
          const imgSrc = doc.hinh_anh_url || FALLBACK_IMG;
          el.innerHTML = `
            <img src="${imgSrc}" alt="${doc.ten_tai_lieu}" class="w-20 h-20 object-cover rounded">
            <div class="flex-1">
              <h3 class="font-medium text-lg">${doc.ten_tai_lieu}</h3>
              <p class="text-gray-600">${doc.mo_ta || ''}</p>
            </div>
            <div class="flex flex-col items-end">
              <span class="font-bold text-lg">${doc.loai === 'cho' ? 'Miễn phí' : (new Intl.NumberFormat('vi-VN').format(doc.gia) + ' VND')}</span>
              <a class="mt-2 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-700" href="${ROUTES.documentShow}/${doc.id}">Xem</a>
            </div>`;
          resultsContainer.appendChild(el);
        });
        results.classList.toggle('hidden', list.length === 0);
        if (list.length === 0) setStatus('Không có tài liệu cho môn học đã chọn.', 'info');
      }).catch(err => { console.error(err); setStatus('Không tải được danh sách tài liệu.', 'error'); });
  });
});
</script>
@endpush
@endsection
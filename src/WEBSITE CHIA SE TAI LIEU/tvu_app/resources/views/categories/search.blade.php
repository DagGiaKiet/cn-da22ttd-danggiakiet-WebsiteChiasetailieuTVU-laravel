@extends('layouts.app')
@section('title','Tài Liệu Học Tập')
@section('content')
<div id="category-search" class="py-8"
  data-api-khoas="/public-api/khoas"
  data-api-nganhs="/public-api/nganhs"
  data-api-mons="/public-api/mons"
  data-api-documents="/public-api/documents"
  data-route-document="/documents"
  data-fallback-img="/img/maclenin.jpg">

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Header with title, search, and upload button --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
      <h1 class="text-3xl font-bold text-gray-900">Tài Liệu Học Tập</h1>
      <div class="flex items-center gap-3 w-full md:w-auto">
        <div class="relative flex-1 md:w-96">
          <input id="qInput" type="text" placeholder="Tìm kiếm tài liệu..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 bg-white text-gray-900 focus:ring-primary focus:border-primary" />
          <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i data-feather="search" class="w-4 h-4"></i></span>
          
          {{-- Global Search Suggestions Dropdown --}}
          <div id="searchSuggestions" class="absolute z-50 top-full left-0 right-0 mt-1 bg-white rounded-lg shadow-xl border border-gray-100 hidden max-h-96 overflow-y-auto">
              <!-- Suggestions will be injected here -->
          </div>
        </div>
        @auth
          <button id="openUploadBtn" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-primary text-white font-medium hover:bg-primary-700">
            <i data-feather="upload" class="w-4 h-4"></i> Tải lên
          </button>
        @else
          <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-primary text-white font-medium hover:bg-primary-700">
            <i data-feather="upload" class="w-4 h-4"></i> Tải lên
          </a>
        @endauth
      </div>
    </div>

    {{-- Filters card --}}
  <div class="bg-white rounded-xl shadow border border-gray-100 p-4 md:p-5 mb-4">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex flex-col sm:flex-row gap-3 sm:items-center flex-1">
          <div class="flex items-center gap-2">
            <span class="text-sm text-gray-600">Lọc theo:</span>
            <div class="relative">
              <select id="faculty" class="min-w-[200px] h-10 appearance-none rounded-lg border border-gray-300 bg-white text-gray-900 text-sm pl-3 pr-10 shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                <option value="" disabled selected hidden>Khoa</option>
              </select>
              <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"><i data-feather="chevron-down" class="w-4 h-4"></i></span>
            </div>
          </div>
          <div class="relative">
            <select id="type" class="min-w-[160px] h-10 appearance-none rounded-lg border border-gray-300 bg-white text-gray-900 text-sm pl-3 pr-10 shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
              <option value="" disabled selected hidden>Loại tài liệu</option>
              <option value="all">Tất cả tài liệu</option>
              <option value="cho">Miễn phí</option>
              <option value="ban">Bán lại</option>
            </select>
            <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"><i data-feather="chevron-down" class="w-4 h-4"></i></span>
          </div>
          <div class="relative">
            <select id="year" class="min-w-[140px] h-10 appearance-none rounded-lg border border-gray-300 bg-white text-gray-900 text-sm pl-3 pr-10 shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
              <option value="" disabled selected hidden>Năm học</option>
            </select>
            <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"><i data-feather="chevron-down" class="w-4 h-4"></i></span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-sm text-gray-600">Sắp xếp:</span>
          <select id="sort" class="rounded-lg border-gray-300 bg-white text-gray-900 focus:border-primary focus:ring-primary">
            <option value="new">Mới nhất</option>
            <option value="price_asc">Giá tăng dần</option>
            <option value="price_desc">Giá giảm dần</option>
          </select>
        </div>
      </div>

      {{-- Advanced selects (optional): Nganh & Mon appear when Khoa is chosen --}}
      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3" id="advancedRow" style="display:none;">
        <div class="relative">
          <select id="major" class="w-full h-10 appearance-none rounded-lg border border-gray-300 bg-white text-gray-900 text-sm pl-3 pr-10 shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
            <option value="">Tất cả ngành</option>
          </select>
          <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"><i data-feather="chevron-down" class="w-4 h-4"></i></span>
        </div>
        <div class="relative">
          <select id="subject" class="w-full h-10 appearance-none rounded-lg border border-gray-300 bg-white text-gray-900 text-sm pl-3 pr-10 shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
            <option value="">Tất cả môn học</option>
          </select>
          <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"><i data-feather="chevron-down" class="w-4 h-4"></i></span>
        </div>
      </div>
    </div>

    {{-- Status --}}
  <div id="statusMsg" class="hidden mb-3 text-sm text-gray-600"></div>

    {{-- Results --}}
    <div class="space-y-3 mb-3">
  <div id="resultsInfo" class="hidden text-sm text-gray-600"></div>
    </div>
    <div id="resultsGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4"></div>

    {{-- Pagination --}}
    <div id="pager" class="mt-6 flex items-center justify-center gap-2"></div>
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
  const ROUTES = { documentShow: root.dataset.routeDocument };
  const FALLBACK_IMG = root.dataset.fallbackImg;

  // Elements
  const qInput = document.getElementById('qInput');
  const selKhoa = document.getElementById('faculty');
  const selNganh = document.getElementById('major');
  const selMon = document.getElementById('subject');
  const rowAdv = document.getElementById('advancedRow');
  const selType = document.getElementById('type');
  const selYear = document.getElementById('year');
  const selSort = document.getElementById('sort');
  const statusMsg = document.getElementById('statusMsg');
  const resultsInfo = document.getElementById('resultsInfo');
  const grid = document.getElementById('resultsGrid');
  const pager = document.getElementById('pager');
  const searchSuggestions = document.getElementById('searchSuggestions');

  // Elements for upload modal
  const modal = document.getElementById('uploadModal');
  const modalBackdrop = document.getElementById('uploadBackdrop');
  const modalPanel = document.getElementById('uploadModalPanel');
  const openBtn = document.getElementById('openUploadBtn');
  const closeBtns = document.querySelectorAll('[data-close-upload]');
  const upForm = document.getElementById('uploadForm');
  const upLoai = document.getElementById('upLoai');
  const priceRow = document.getElementById('upPriceRow');
  const upGia = document.getElementById('upGia');
  const upKhoa = document.getElementById('upKhoa');
  const upNganh = document.getElementById('upNganh');
  const upMon = document.getElementById('upMon');
  const upMonNewDiv = document.getElementById('upMonNewDiv');
  const upMonNewInput = document.getElementById('upMonNewInput');

  let allDocs = [];
  let currentPage = 1;
  const pageSize = 6;

  // Helpers
  function setStatus(message, type='info'){
    if (!message) { statusMsg.classList.add('hidden'); statusMsg.textContent=''; return; }
  statusMsg.classList.remove('hidden');
  statusMsg.className = 'mb-3 text-sm ' + (type==='error' ? 'text-red-600' : 'text-gray-600');
    statusMsg.textContent = message;
  }
  function setInfo(txt){
    if (!txt) { resultsInfo.classList.add('hidden'); resultsInfo.textContent=''; return; }
    resultsInfo.classList.remove('hidden');
    resultsInfo.textContent = txt;
  }
  function debounce(fn, d=250){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), d); }; }

  // Populate Khoa
  fetch(API.khoas).then(r=>r.json()).then(list=>{
    // Add "Tất cả khoa" option
    const allOpt=document.createElement('option'); allOpt.value='all'; allOpt.textContent='Tất cả khoa'; selKhoa.appendChild(allOpt);
    list.forEach(k=>{ const o=document.createElement('option'); o.value=k.id; o.textContent=k.ten_khoa; selKhoa.appendChild(o); });
  }).catch(()=> setStatus('Không tải được danh sách Khoa.', 'error'));

  // Populate Khoa in Upload modal on first open
  let uploadKhoaLoaded = false;
  function ensureUploadKhoa(){
    if (uploadKhoaLoaded) return;
    fetch(API.khoas).then(r=>r.json()).then(list=>{
      list.forEach(k=>{ const o=document.createElement('option'); o.value=k.id; o.textContent=k.ten_khoa; upKhoa.appendChild(o); });
      uploadKhoaLoaded = true;
    }).catch(()=>{/* silent in modal */});
  }

  // Populate Year (last 6 years)
  const thisYear = new Date().getFullYear();
  // Add "Tất cả năm học"
  const allYear=document.createElement('option'); allYear.value='all'; allYear.textContent='Tất cả năm học'; selYear.appendChild(allYear);
  for (let y=thisYear; y>=thisYear-6; y--){
    const o=document.createElement('option'); o.value=y; o.textContent=y; selYear.appendChild(o);
  }

  // Change handlers
  selKhoa.addEventListener('change', ()=>{
    // Show advanced selects and fetch Ngành
    selNganh.innerHTML = '<option value="">Tất cả ngành</option>';
    selMon.innerHTML = '<option value="">Tất cả môn học</option>';
    if (searchSuggestions) searchSuggestions.classList.add('hidden'); 
    
    if (selKhoa.value && selKhoa.value!=='all'){
      rowAdv.style.display='grid';
      fetch(`${API.nganhs}?khoa_id=${encodeURIComponent(selKhoa.value)}`)
        .then(r=>r.json()).then(list=>{
          list.forEach(n=>{ const o=document.createElement('option'); o.value=n.id; o.textContent=n.ten_nganh; selNganh.appendChild(o); });
        }).catch(()=> setStatus('Không tải được danh sách Ngành.', 'error'));
    } else {
      rowAdv.style.display='none';
    }
    currentPage = 1; loadDocuments();
  });
  selNganh.addEventListener('change', ()=>{
    selMon.innerHTML = '<option value="">Tất cả môn học</option>';
    if (selNganh.value){
      fetch(`${API.mons}?nganh_id=${encodeURIComponent(selNganh.value)}`)
        .then(r=>r.json()).then(list=>{
          list.forEach(m=>{ const o=document.createElement('option'); o.value=m.id; o.textContent=m.ten_mon; selMon.appendChild(o); });
        }).catch(()=> setStatus('Không tải được danh sách Môn học.', 'error'));
    }
    currentPage = 1; loadDocuments();
  });
  selMon.addEventListener('change', ()=>{ currentPage=1; loadDocuments(); });
  selType.addEventListener('change', ()=>{ currentPage=1; render(); });
  selYear.addEventListener('change', ()=>{ currentPage=1; render(); });
  selSort.addEventListener('change', ()=>{ currentPage=1; render(); });
  
  // Search Suggestions Logic
  @auth const isLoggedIn = true; @else const isLoggedIn = false; @endauth

  qInput.addEventListener('input', debounce(()=>{
      const q = qInput.value.trim();
      const hasFilter = selKhoa.value && selKhoa.value !== 'all';

      // Hide suggestions if query is empty
      if(!q) {
          searchSuggestions.classList.add('hidden');
          if(hasFilter) { currentPage=1; render(); }
          return;
      }

      if (hasFilter) {
          // Mode 1: Filter existing loaded docs
          searchSuggestions.classList.add('hidden');
          currentPage=1;
          render();
      } else {
          // Mode 2: Global Search Suggestions
          if (q.length < 2) {
              searchSuggestions.classList.add('hidden');
              return;
          }
          fetchSuggestions(q);
      }
  }));
  
  // Close suggestions when clicking outside
  document.addEventListener('click', (e) => {
    if (searchSuggestions && !qInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
      searchSuggestions.classList.add('hidden');
    }
  });

  function fetchSuggestions(query) {
    if (!query) return;
    fetch(`${API.documents}?q=${encodeURIComponent(query)}`)
      .then(r => r.json())
      .then(list => {
        renderSuggestions(list);
      })
      .catch(() => {});
  }

  function renderSuggestions(list) {
    searchSuggestions.innerHTML = '';
    if (!list || !Array.isArray(list) || list.length === 0) {
      searchSuggestions.classList.add('hidden');
      return;
    }
    
    // Sort logic from server or just take top results
    const items = list.slice(0, 10);
    searchSuggestions.classList.remove('hidden');

    if (items.length === 0) {
        searchSuggestions.innerHTML = '<div class="p-3 text-sm text-gray-500">Không tìm thấy kết quả</div>';
        return;
    }

    items.forEach(doc => {
      const div = document.createElement('div');
      div.className = 'flex items-start gap-3 p-3 hover:bg-gray-50 cursor-pointer border-b last:border-0 transition-colors pointer-events-auto'; // pointer-events-auto just in case
      
      const isFree = doc.loai === 'cho';
      const amount = new Intl.NumberFormat('vi-VN').format(doc.gia||0);
      const priceText = isFree ? 'Miễn phí' : `${amount}đ`;
      const priceClass = isFree ? 'text-green-600' : 'text-indigo-600';
      const kName = doc.khoa ? doc.khoa.ten_khoa : (doc.khoa_ten || '');

      div.innerHTML = `
        <div class="mt-1 w-8 h-8 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-sm font-medium text-gray-900 truncate">${doc.ten_tai_lieu}</div>
          <div class="flex items-center justify-between mt-1">
             <span class="text-xs text-gray-500 truncate mr-2">${kName}</span>
             <span class="text-xs font-semibold ${priceClass} whitespace-nowrap">${priceText}</span>
          </div>
        </div>
      `;
      
      div.addEventListener('click', (e) => {
        // Prevent default navigation? Not needed as it is a div
        e.stopPropagation(); 
        
        if (!isLoggedIn) {
          // Guest
          if(confirm('Bạn cần đăng nhập để xem chi tiết tài liệu này.\\nĐăng nhập ngay/đăng ký?')) {
            window.location.href = '/login';
          }
        } else {
            // User
            window.location.href = `/documents/${doc.id}`;
        }
      });
      
      searchSuggestions.appendChild(div);
    });
  }

  // Upload modal events
  function togglePrice(){
    const show = upLoai && upLoai.value === 'ban';
    if (!priceRow) return;
    if (show){ priceRow.classList.remove('hidden'); upGia.removeAttribute('disabled'); upGia.setAttribute('required','required'); if (!upGia.value || Number(upGia.value)<=0) upGia.value = ''; }
    else { priceRow.classList.add('hidden'); upGia.setAttribute('disabled','disabled'); upGia.removeAttribute('required'); upGia.value = 0; }
  }
  if (upLoai){ upLoai.addEventListener('change', togglePrice); togglePrice(); }

  function openModal(){
    if (!modal) return;
    ensureUploadKhoa();
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    requestAnimationFrame(()=>{
      if (modalBackdrop){ modalBackdrop.classList.remove('opacity-0'); modalBackdrop.classList.add('opacity-100'); }
      if (modalPanel){ modalPanel.classList.remove('opacity-0','-translate-y-3','scale-95'); modalPanel.classList.add('opacity-100','translate-y-0','scale-100'); }
    });
  }
  function closeModal(){
    if (!modal) return;
    if (modalBackdrop){ modalBackdrop.classList.add('opacity-0'); modalBackdrop.classList.remove('opacity-100'); }
    if (modalPanel){ modalPanel.classList.add('opacity-0','-translate-y-3','scale-95'); modalPanel.classList.remove('opacity-100','translate-y-0','scale-100'); }
    setTimeout(()=>{ modal.classList.add('hidden'); document.body.classList.remove('overflow-hidden'); }, 180);
  }
  if (openBtn) openBtn.addEventListener('click', openModal);
  closeBtns.forEach(b=> b.addEventListener('click', closeModal));
  if (modalBackdrop) modalBackdrop.addEventListener('click', closeModal);

  // Auto-open when URL contains ?upload=1
  try {
    const usp = new URLSearchParams(window.location.search);
    if (usp.get('upload') === '1') openModal();
  } catch(e) {}

  // Cascading selects in upload form
  if (upKhoa){
    upKhoa.addEventListener('change', ()=>{
      upNganh.innerHTML = '<option value="">Chọn ngành</option>';
      upMon.innerHTML = '<option value="">Chọn môn học</option>';
      if (upKhoa.value){
        fetch(`${API.nganhs}?khoa_id=${encodeURIComponent(upKhoa.value)}`)
          .then(r=>r.json()).then(list=>{
            list.forEach(n=>{ const o=document.createElement('option'); o.value=n.id; o.textContent=n.ten_nganh; upNganh.appendChild(o); });
          }).catch(()=>{});
      }
    });
  }
  if (upNganh){
    upNganh.addEventListener('change', ()=>{
      upMon.innerHTML = '<option value="">Chọn môn học</option>';
      // Reset new mon input
      if (upMonNewDiv) upMonNewDiv.classList.add('hidden');
      if (upMonNewInput) { upMonNewInput.removeAttribute('required'); upMonNewInput.value = ''; }
      
      if (upNganh.value){
        fetch(`${API.mons}?nganh_id=${encodeURIComponent(upNganh.value)}`)
          .then(r=>r.json()).then(list=>{
            list.forEach(m=>{ const o=document.createElement('option'); o.value=m.id; o.textContent=m.ten_mon; upMon.appendChild(o); });
             // Add "Other" option
            const otherOpt = document.createElement('option'); 
            otherOpt.value = 'other'; 
            otherOpt.textContent = '-- Nhập môn học mới --'; 
            otherOpt.className = 'text-primary font-medium';
            upMon.appendChild(otherOpt);
          }).catch(()=>{});
      }
    });
  }
  
  if (upMon) {
      upMon.addEventListener('change', () => {
          if (upMon.value === 'other') {
              if (upMonNewDiv) upMonNewDiv.classList.remove('hidden');
              if (upMonNewInput) upMonNewInput.setAttribute('required', 'required');
              if (upMonNewInput) setTimeout(() => upMonNewInput.focus(), 100);
          } else {
              if (upMonNewDiv) upMonNewDiv.classList.add('hidden');
              if (upMonNewInput) { upMonNewInput.removeAttribute('required'); upMonNewInput.value = ''; }
          }
      });
  }

  function buildParams(){
    const params = new URLSearchParams();
  if (selKhoa.value && selKhoa.value!=='all') params.set('khoa_id', selKhoa.value);
    if (selNganh.value) params.set('nganh_id', selNganh.value);
    if (selMon.value) params.set('mon_id', selMon.value);
    // We let server sort by created_at/price; other filters (type/year/q) are client-side to reduce API churn
    params.set('sort', selSort.value || 'new');
    // If no filter at all, don't query to avoid returning everything
    if (![...params.keys()].length) return null;
    return params.toString();
  }

  function loadDocuments(){
    const qs = buildParams();
    if (!qs){
      allDocs = []; render(); setInfo('Hãy chọn Khoa hoặc chi tiết hơn để xem tài liệu.'); return;
    }
    setStatus('Đang tải dữ liệu...');
    fetch(`${API.documents}?${qs}`)
      .then(r=>r.json()).then(list=>{
        allDocs = Array.isArray(list) ? list : [];
        setStatus('');
        render();
      }).catch(()=> setStatus('Không tải được danh sách tài liệu.', 'error'));
  }

  function filtered(){
    const q = qInput.value.trim().toLowerCase();
    const t = selType.value;
  const y = selYear.value;
    let arr = allDocs.slice();
    if (q) arr = arr.filter(d => (d.ten_tai_lieu && d.ten_tai_lieu.toLowerCase().includes(q)) || (d.mo_ta && d.mo_ta.toLowerCase().includes(q)) );
    if (t && t !== 'all') arr = arr.filter(d => d.loai === t);
  if (y && y !== 'all') arr = arr.filter(d => (d.created_at && new Date(d.created_at).getFullYear().toString()===y) || (d.created_date && d.created_date.endsWith('/'+y)) );
    // sort client side to reflect current select (server already applied basic sort when fetching)
    const sort = selSort.value;
    if (sort==='price_asc') arr.sort((a,b)=>(a.gia||0)-(b.gia||0));
    else if (sort==='price_desc') arr.sort((a,b)=>(b.gia||0)-(a.gia||0));
    else arr.sort((a,b)=> new Date(b.created_at||0) - new Date(a.created_at||0));
    return arr;
  }

  function render(){
    const list = filtered();
    const total = list.length;
    setInfo(total? `Có ${total} tài liệu phù hợp` : 'Không có tài liệu phù hợp');

    // pagination
    const pages = Math.max(1, Math.ceil(total / pageSize));
    if (currentPage>pages) currentPage=pages;
    const start = (currentPage-1)*pageSize;
    const pageItems = list.slice(start, start+pageSize);

    // render cards
  grid.innerHTML = '';
    pageItems.forEach(doc=> grid.appendChild(renderCard(doc)) );
    if (window.feather) window.feather.replace();

    // render pager
    pager.innerHTML = '';
    if (pages>1){
      const mkBtn=(label, page, disabled=false, active=false)=>{
        const a=document.createElement('button');
        a.textContent=label;
        a.className = 'px-3 py-1.5 rounded-md border text-sm ' + (active? 'bg-primary text-white border-primary' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50');
        a.disabled=disabled; if (!disabled) a.addEventListener('click', ()=>{ currentPage=page; render(); });
        return a;
      };
      pager.appendChild(mkBtn('«', Math.max(1,currentPage-1), currentPage===1));
      for (let p=1;p<=pages;p++) pager.appendChild(mkBtn(String(p), p, false, p===currentPage));
      pager.appendChild(mkBtn('»', Math.min(pages,currentPage+1), currentPage===pages));
    }
  }

  function renderCard(doc){
  const card=document.createElement('div');
  card.className='rounded-xl border border-gray-200 bg-white shadow hover:shadow-md transition p-5 flex overflow-hidden';
    const isFree = doc.loai==='cho';
    const amount = new Intl.NumberFormat('vi-VN').format(doc.gia||0);
    const priceHTML = isFree
      ? '<span class="px-2 py-1 rounded-full bg-green-50 text-green-600 text-xs font-medium">Miễn phí</span>'
      : `<div class="text-right leading-tight"><div class="text-lg font-semibold text-gray-900">${amount}</div><div class="text-xs font-medium text-gray-500">VND</div></div>`;
    const dateTxt = doc.created_date || (doc.created_at? new Date(doc.created_at).toLocaleDateString('vi-VN',{month:'2-digit',year:'numeric'}) : '');
    const khoaTxt = doc.khoa_ten ? `Khoa ${doc.khoa_ten}` : '';
    
    card.innerHTML = `
      <div class="mr-4">
        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
          <i data-feather="book" class="w-5 h-5"></i>
        </div>
      </div>
      <div class="flex-1 min-w-0">
        <h3 class="text-base font-semibold text-gray-900 truncate">${doc.ten_tai_lieu||''}</h3>
        <div class="text-xs text-gray-500 mt-0.5">${khoaTxt}</div>
        <p class="mt-2 text-sm text-gray-600 line-clamp-2">${doc.mo_ta||''}</p>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 items-center gap-3 text-sm">
          <div class="flex items-center gap-4 text-gray-500">
            <span class="inline-flex items-center gap-2"><i data-feather=\"calendar\" class=\"w-4 h-4\"></i> ${dateTxt}</span>
            <span class="inline-flex items-center gap-1"><i data-feather=\"eye\" class=\"w-4 h-4\"></i> 0</span>
            <span class="inline-flex items-center gap-1"><i data-feather=\"download\" class=\"w-4 h-4\"></i> 0</span>
          </div>
          <div class="flex items-center justify-end gap-3 flex-wrap">
            <div class="text-right">${priceHTML}</div>
            <a href="${ROUTES.documentShow}/${doc.id}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-primary text-white hover:bg-primary-700">
              Xem <i data-feather="eye" class="w-4 h-4"></i>
            </a>
          </div>
        </div>
      </div>`;
    return card;
  }

  // Initial state: prompt to select
  setInfo('Hãy chọn Khoa hoặc chi tiết hơn để xem tài liệu.');
});
</script>
@endpush

{{-- Upload Modal --}}
@auth
<div id="uploadModal" class="hidden fixed inset-0 z-50">
  <div id="uploadBackdrop" class="absolute inset-0 bg-black/40 opacity-0 transition-opacity duration-200"></div>
  <div class="relative z-10 max-w-4xl mx-auto my-8">
    <div id="uploadModalPanel" class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden transform transition-all duration-200 ease-out opacity-0 -translate-y-3 scale-95">
      <div class="flex items-center justify-between px-6 py-4 border-b bg-gray-50">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
            <i data-feather="upload" class="w-4 h-4"></i>
          </div>
          <h3 class="text-lg font-semibold text-gray-900">Đăng tài liệu</h3>
        </div>
        <button type="button" class="p-2 rounded-md hover:bg-gray-100 text-gray-500" aria-label="Đóng" data-close-upload>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
        </button>
      </div>
      <form id="uploadForm" method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="max-h-[80vh] overflow-y-auto">
        @csrf
        <div class="p-6 space-y-5">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Tên tài liệu <span class="text-red-500">*</span></label>
              <input name="ten_tai_lieu" required placeholder="VD: Bài tập lớn môn Cơ sở dữ liệu" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh bìa</label>
              <input type="file" name="hinh_anh" accept="image/*" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 focus:ring-2 focus:ring-primary/20 focus:border-primary" />
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea name="mo_ta" rows="4" placeholder="Mô tả ngắn gọn nội dung tài liệu..." class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary"></textarea>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Khoa <span class="text-red-500">*</span></label>
              <select id="upKhoa" name="khoa_id" required class="block w-full h-11 rounded-lg border border-gray-300 bg-white px-3 text-gray-900 focus:ring-2 focus:ring-primary/20 focus:border-primary">
                <option value="" disabled selected hidden>Chọn khoa</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Ngành <span class="text-red-500">*</span></label>
              <select id="upNganh" name="nganh_id" required class="block w-full h-11 rounded-lg border border-gray-300 bg-white px-3 text-gray-900 focus:ring-2 focus:ring-primary/20 focus:border-primary">
                <option value="">Chọn ngành</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Môn học <span class="text-red-500">*</span></label>
              <select id="upMon" name="mon_id" required class="block w-full h-11 rounded-lg border border-gray-300 bg-white px-3 text-gray-900 focus:ring-2 focus:ring-primary/20 focus:border-primary">
                <option value="">Chọn môn học</option>
              </select>
              <div id="upMonNewDiv" class="mt-2 hidden">
                  <input id="upMonNewInput" name="ten_mon_moi" type="text" placeholder="Nhập tên môn học mới..." class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:ring-2 focus:ring-primary/20 focus:border-primary" />
              </div>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Hình thức</label>
              <select id="upLoai" name="loai" class="block w-full h-11 rounded-lg border border-gray-300 bg-white px-3 text-gray-900 focus:ring-2 focus:ring-primary/20 focus:border-primary">
                <option value="cho">Miễn phí</option>
                <option value="ban">Bán lại giá rẻ</option>
              </select>
            </div>
            <div id="upPriceRow">
              <label class="block text-sm font-medium text-gray-700 mb-1">Giá (đ)</label>
              <input id="upGia" type="number" step="1000" min="0" name="gia" value="0" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-gray-900 focus:ring-2 focus:ring-primary/20 focus:border-primary" />
            </div>
          </div>
        </div>
        <div class="flex items-center justify-end gap-2 px-6 py-4 border-t bg-gray-50">
          <button type="button" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-white" data-close-upload>Hủy</button>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary-700">Đăng</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endauth
@endsection
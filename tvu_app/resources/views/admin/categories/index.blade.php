@extends('layouts.admin')
@section('title','Admin - Quản lý danh mục')
@section('content')
<div id="categories-page" class="max-w-7xl mx-auto py-4">
  <div class="mb-4">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Quản lý danh mục</h2>
  <p class="text-sm text-gray-900 dark:text-gray-200">Thêm và theo dõi Khoa, Ngành, Môn học</p>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Khoa -->
    <div class="admin-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-sm">
      <div class="p-5 border-b border-gray-200 dark:border-gray-800">
        <h3 class="font-semibold text-gray-900 dark:text-gray-100">Khoa <span class="text-sm font-normal text-gray-900 dark:text-gray-200">({{ count($khoas) }})</span></h3>
      </div>
      <div class="p-5 space-y-4">
        <form method="POST" action="{{ route('admin.khoas.store') }}" class="flex gap-2">@csrf
          <input name="ten_khoa" class="flex-1 border border-gray-300 dark:border-gray-700 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder:text-gray-900 dark:placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tên khoa">
          <button class="px-3 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">Thêm</button>
        </form>
        <ul class="max-h-72 overflow-auto pr-2 divide-y divide-gray-200 dark:divide-gray-800">
          @foreach($khoas as $k)
            <li class="py-2">
              <div class="flex items-center gap-2 text-sm text-gray-900 dark:text-gray-200">
                <i data-feather="circle" class="h-3 w-3 text-indigo-500"></i>
                <span class="text-gray-900 dark:text-gray-200">{{ $k->ten_khoa }}</span>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>

    <!-- Ngành -->
    <div class="admin-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-sm">
      <div class="p-5 border-b border-gray-200 dark:border-gray-800">
        <h3 class="font-semibold text-gray-900 dark:text-gray-100">Ngành <span class="text-sm font-normal text-gray-900 dark:text-gray-200">({{ count($nganhs) }})</span></h3>
      </div>
      <div class="p-5 space-y-4">
        <form method="POST" action="{{ route('admin.nganhs.store') }}" class="space-y-2">@csrf
          <select name="khoa_id" class="w-full border border-gray-300 dark:border-gray-700 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @foreach($khoas as $k)
              <option value="{{ $k->id }}">{{ $k->ten_khoa }}</option>
            @endforeach
          </select>
          <div class="flex gap-2">
            <input name="ten_nganh" class="flex-1 border border-gray-300 dark:border-gray-700 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder:text-gray-900 dark:placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tên ngành">
            <button class="px-3 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">Thêm</button>
          </div>
        </form>
        <ul class="max-h-72 overflow-auto pr-2 divide-y divide-gray-200 dark:divide-gray-800">
          @foreach($nganhs as $n)
            <li class="py-2">
              <div class="flex items-center gap-2 text-sm text-gray-900 dark:text-gray-200">
                <i data-feather="bookmark" class="h-4 w-4 text-indigo-500"></i>
                <span class="text-gray-900 dark:text-gray-200">{{ $n->ten_nganh }} <span class="text-gray-900 dark:text-gray-300">({{ $n->khoa->ten_khoa }})</span></span>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>

    <!-- Môn -->
    <div class="admin-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-sm">
      <div class="p-5 border-b border-gray-200 dark:border-gray-800">
        <h3 class="font-semibold text-gray-900 dark:text-gray-100">Môn <span class="text-sm font-normal text-gray-900 dark:text-gray-200">({{ count($mons) }})</span></h3>
      </div>
      <div class="p-5 space-y-4">
        <form method="POST" action="{{ route('admin.mons.store') }}" class="space-y-2">@csrf
          <select name="nganh_id" class="w-full border border-gray-300 dark:border-gray-700 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @foreach($nganhs as $n)
              <option value="{{ $n->id }}">{{ $n->ten_nganh }}</option>
            @endforeach
          </select>
          <div class="flex gap-2">
            <input name="ten_mon" class="flex-1 border border-gray-300 dark:border-gray-700 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder:text-gray-900 dark:placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tên môn">
            <button class="px-3 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">Thêm</button>
          </div>
        </form>
        <ul class="max-h-72 overflow-auto pr-2 divide-y divide-gray-200 dark:divide-gray-800">
          @foreach($mons as $m)
            <li class="py-2">
              <div class="flex items-center gap-2 text-sm text-gray-900 dark:text-gray-200">
                <i data-feather="book" class="h-4 w-4 text-indigo-500"></i>
                <span class="text-gray-900 dark:text-gray-200">{{ $m->ten_mon }} <span class="text-gray-900 dark:text-gray-300">({{ $m->nganh->ten_nganh }} - {{ $m->nganh->khoa->ten_khoa }})</span></span>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  <style>
    /* Page-specific: nicer thin scrollbar */
    .admin-card ul::-webkit-scrollbar { height: 8px; width: 8px; }
    .admin-card ul::-webkit-scrollbar-thumb { background-color: rgba(99,102,241,.5); border-radius: 6px; }
    .admin-card ul::-webkit-scrollbar-track { background: rgba(0,0,0,.05); }
    /* Force black text for lists and captions in light mode */
    html[data-theme="light"] #categories-page h2,
    html[data-theme="light"] #categories-page h3,
    html[data-theme="light"] #categories-page p,
    html[data-theme="light"] #categories-page ul li,
    html[data-theme="light"] #categories-page ul li span { color: #111827 !important; }
  </style>
</div>
@endsection

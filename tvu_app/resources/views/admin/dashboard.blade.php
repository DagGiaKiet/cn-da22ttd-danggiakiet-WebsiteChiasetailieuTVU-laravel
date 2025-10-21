@extends('layouts.app')
@section('title','Admin Panel - TVU')
@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-0 py-4">
  <div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Tổng quan hệ thống</h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600">Người dùng</div>
        <div class="text-2xl font-semibold">{{ $users }}</div>
      </div>
      <div class="border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600">Tài liệu</div>
        <div class="text-2xl font-semibold">{{ $documents }}</div>
      </div>
      <div class="border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600">Đơn hàng</div>
        <div class="text-2xl font-semibold">{{ $orders }}</div>
      </div>
      <div class="border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600">Bài blog</div>
        <div class="text-2xl font-semibold">{{ $blogs }}</div>
      </div>
    </div>
  </div>
</div>
@endsection

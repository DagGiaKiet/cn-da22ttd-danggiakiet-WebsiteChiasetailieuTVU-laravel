@extends('layouts.admin')
@section('title', 'Quản lý liên hệ')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
            <i data-feather="mail" class="w-6 h-6"></i> Quản lý liên hệ
        </h1>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Quay lại bảng điều khiển
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="p-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">ID</th>
                        <th class="p-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Người gửi</th>
                        <th class="p-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Chủ đề</th>
                        <th class="p-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Nội dung</th>
                        <th class="p-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Trạng thái</th>
                        <th class="p-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Ngày gửi</th>
                        <th class="p-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($contacts as $contact)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="p-4 text-sm text-gray-500">#{{ $contact->id }}</td>
                        <td class="p-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $contact->name }}</div>
                            <div class="text-xs text-gray-500">{{ $contact->email }}</div>
                        </td>
                        <td class="p-4 text-sm text-gray-700 dark:text-gray-300">{{ $contact->subject }}</td>
                        <td class="p-4 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate" title="{{ $contact->message }}">
                            {{ $contact->message }}
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.contacts.update-status', $contact) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-xs rounded-full px-3 py-1 font-medium border-0 focus:ring-2 cursor-pointer {{ $contact->status === 'processed' ? 'bg-green-100 text-green-800 focus:ring-green-500' : 'bg-yellow-100 text-yellow-800 focus:ring-yellow-500' }}">
                                    <option value="pending" {{ $contact->status === 'pending' ? 'selected' : '' }}>Chưa xử lý</option>
                                    <option value="processed" {{ $contact->status === 'processed' ? 'selected' : '' }}>Đã xử lý</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4 text-sm text-gray-500">
                            {{ $contact->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50" title="Xóa">
                                    <i data-feather="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            Chưa có liên hệ nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contacts->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-700">
            {{ $contacts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@foreach($orders as $o)
<tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">#{{ $o->id }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $o->user->name ?? 'N/A' }}<span class="text-gray-500 dark:text-gray-400"> ({{ $o->user->email ?? '' }})</span></td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $o->document->ten_tai_lieu ?? 'N/A' }}</td>
  <td class="px-6 py-4 whitespace-nowrap">
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $o->trang_thai === 'dang_giao' ? 'bg-yellow-100 text-yellow-800' : ($o->trang_thai === 'da_nhan' ? 'bg-green-100 text-green-800' : ($o->trang_thai === 'huy' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
      {{ $o->trang_thai }}
    </span>
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
    <form method="POST" action="{{ route('admin.orders.update-status', $o) }}" class="flex items-center space-x-2">
      @csrf
      <select name="trang_thai" class="border border-gray-300 dark:border-gray-600 rounded-md px-2 py-1 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
        @foreach(['pending','dang_giao','da_nhan','huy'] as $s)
          <option value="{{ $s }}" @selected($o->trang_thai===$s)>{{ $s }}</option>
        @endforeach
      </select>
      <button class="px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">Lưu</button>
    </form>
  </td>
</tr>
@endforeach
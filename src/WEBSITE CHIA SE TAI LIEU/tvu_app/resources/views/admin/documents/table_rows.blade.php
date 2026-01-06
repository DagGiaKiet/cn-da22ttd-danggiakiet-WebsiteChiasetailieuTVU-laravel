@foreach($documents as $d)
  <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $d->id }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $d->ten_tai_lieu }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $d->user->name ?? 'N/A' }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $d->loai }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $d->loai==='cho' ? 'Miễn phí' : number_format($d->gia, 0, ',', '.') . ' VND' }}</td>
    <td class="px-6 py-4 whitespace-nowrap">
      <form method="POST" action="{{ route('admin.documents.update-status', $d) }}" class="flex items-center space-x-2">
        @csrf
        <select name="trang_thai" class="border border-gray-300 dark:border-gray-600 rounded-md px-2 py-1 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
          onchange="this.form.submit()">
          <option value="available" {{ $d->trang_thai === 'available' ? 'selected' : '' }}>Có sẵn</option>
          <option value="sold" {{ $d->trang_thai === 'sold' ? 'selected' : '' }}>Hết hàng</option>
        </select>
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $d->trang_thai === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $d->trang_thai === 'available' ? 'Còn' : 'Hết' }}
        </span>
      </form>
    </td>
  </tr>
@endforeach
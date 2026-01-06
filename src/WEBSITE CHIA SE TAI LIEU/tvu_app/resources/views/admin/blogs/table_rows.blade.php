@foreach($blogs as $b)
<tr class="bg-white dark:bg-gray-900 hover:bg-indigo-50 dark:hover:bg-gray-800 transition-colors">
  <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ $b->id }}</td>
  <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $b->tieu_de }}</td>
  <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">{{ $b->user->name ?? 'N/A' }}</td>
</tr>
@endforeach
@foreach($users as $u)
  @php /** @var \App\Models\User $u */ @endphp
  <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $u->id }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $u->name }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $u->email }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
      <div class="flex items-center gap-2">
      <form method="POST" action="{{ route('admin.users.update-role', $u) }}" class="inline-flex items-center gap-2">
        @csrf
        <select name="role" class="border border-gray-300 dark:border-gray-600 rounded-md text-sm px-2 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
          @if(auth()->id() === $u->id) disabled @endif>
          <option value="student" {{ $u->role === 'student' ? 'selected' : '' }}>student</option>
          <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>admin</option>
        </select>
        <button type="submit" class="p-1.5 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 disabled:opacity-50 inline-flex items-center justify-center" title="Lưu role"
          @if(auth()->id() === $u->id) disabled @endif>
          <span class="material-symbols-outlined text-[18px]">save</span>
        </button>
      </form>
      </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
      @if(auth()->id() !== $u->id)
      <div class="flex items-center gap-2">
          <!-- View Info -->
          <button type="button" class="p-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 inline-flex items-center justify-center transition-colors" title="Xem thông tin" onclick="showUserInfo({{ $u->id }})">
              <span class="material-symbols-outlined text-[20px]">visibility</span>
          </button>
          
          <!-- Lock/Unlock -->
          <button type="button" 
                  onclick="showToggleStatus('{{ route('admin.users.toggle-status', $u) }}', '{{ $u->status }}', '{{ $u->name }}')"
                  class="p-2 {{ $u->status == 'locked' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} rounded-md inline-flex items-center justify-center transition-colors" 
                  title="{{ $u->status == 'locked' ? 'Mở khóa' : 'Khóa tài khoản' }}">
              <span class="material-symbols-outlined text-[20px]">{{ $u->status == 'locked' ? 'lock_open' : 'lock' }}</span>
          </button>

          <!-- Reset Password -->
          <button type="button" class="p-2 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 inline-flex items-center justify-center transition-colors" title="Reset mật khẩu" onclick="showResetPassword({{ $u->id }}, '{{ $u->name }}')">
              <span class="material-symbols-outlined text-[20px]">vpn_key</span>
          </button>
      </div>
      @else
        <span class="text-xs text-gray-400 dark:text-gray-500 italic">(Tài khoản của bạn)</span>
      @endif
    </td>
  </tr>
@endforeach
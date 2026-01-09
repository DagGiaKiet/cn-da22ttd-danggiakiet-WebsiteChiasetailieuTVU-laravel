<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Danh sách người dùng
	public function index(Request $request)
	{
		$query = User::whereIn('role', ['student','admin']);

        if ($request->has('search') && $request->search != '') {
             $search = $request->search;
             $query->where(function($q) use ($search) {
                 $q->where('name', 'LIKE', "%{$search}%")
                   ->orWhere('email', 'LIKE', "%{$search}%")
                   ->orWhere('id', 'LIKE', "%{$search}%");
             });
        }

		$users = $query->latest()->paginate(20);

        if ($request->ajax()) {
            return view('admin.users.table_rows', compact('users'))->render();
        }

		return view('admin.users.index', compact('users'));
	}

	/**
	 * // Cập nhật vai trò người dùng (admin | student)
	 */
	public function updateRole(Request $request, User $user)
	{
		$validated = $request->validate([
			'role' => 'required|in:student,admin',
		]);

		// Ngăn chặn việc tự xóa quyền admin của chính mình
		if (auth()->id() === $user->id && $validated['role'] !== 'admin') {
			return back()->with('error', 'Bạn không thể tự hạ quyền của chính mình.');
		}

		$user->role = $validated['role'];
		$user->save();

		return back()->with('success', 'Cập nhật quyền thành công cho người dùng: ' . ($user->name ?? $user->email));
	}

    // Hiển thị chi tiết người dùng
    public function show(User $user)
    {
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'ma_sv' => $user->ma_sv,
            'ma_lop' => $user->ma_lop,
            'khoa' => $user->khoa,
            'nganh' => $user->nganh,
            'created_at' => $user->created_at->format('d/m/Y H:i'),
            'status' => $user->status ?? 'active',
            'avatar_url' => $user->avatar ? asset('storage/'.$user->avatar) : null,
            'anh_the_url' => $user->anh_the ? asset('storage/'.$user->anh_the) : null,
        ]);
    }

    // Chuyển đổi trạng thái (Khóa/Mở khóa)
    public function toggleStatus(User $user)
    {
        $newStatus = ($user->status === 'locked') ? 'active' : 'locked';
        $user->update(['status' => $newStatus]);
        return back()->with('success', 'đã cập nhật trạng thái tài khoản thành ' . ($newStatus == 'active' ? 'Hoạt động' : 'Đã khóa'));
    }

    // Đặt lại mật khẩu người dùng
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)
        ]);

        return back()->with('success', 'Đã đặt lại mật khẩu thành công.');
    }
}


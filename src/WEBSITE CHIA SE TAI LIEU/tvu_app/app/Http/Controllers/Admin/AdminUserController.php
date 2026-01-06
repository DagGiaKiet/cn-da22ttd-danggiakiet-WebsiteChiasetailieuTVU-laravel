<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
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
	 * Update a user's role (admin | student)
	 */
	public function updateRole(Request $request, User $user)
	{
		$validated = $request->validate([
			'role' => 'required|in:student,admin',
		]);

		// Prevent accidentally removing your own admin access
		if (auth()->id() === $user->id && $validated['role'] !== 'admin') {
			return back()->with('error', 'Bạn không thể tự hạ quyền của chính mình.');
		}

		$user->role = $validated['role'];
		$user->save();

		return back()->with('success', 'Cập nhật quyền thành công cho người dùng: ' . ($user->name ?? $user->email));
	}

    public function show(User $user)
    {
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'created_at' => $user->created_at->format('d/m/Y H:i'),
            'status' => $user->status ?? 'active',
        ]);
    }

    public function toggleStatus(User $user)
    {
        $newStatus = ($user->status === 'locked') ? 'active' : 'locked';
        $user->update(['status' => $newStatus]);
        return back()->with('success', 'đã cập nhật trạng thái tài khoản thành ' . ($newStatus == 'active' ? 'Hoạt động' : 'Đã khóa'));
    }

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


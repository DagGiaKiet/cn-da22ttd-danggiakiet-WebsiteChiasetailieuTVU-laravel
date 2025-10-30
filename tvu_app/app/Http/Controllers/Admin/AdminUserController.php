<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
	public function index()
	{
		$users = User::whereIn('role', ['student','admin'])->latest()->paginate(20);
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
}


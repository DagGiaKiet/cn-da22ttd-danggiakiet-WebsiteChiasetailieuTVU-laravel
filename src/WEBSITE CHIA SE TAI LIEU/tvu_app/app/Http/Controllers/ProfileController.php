<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
	public function index(Request $request)
	{
		$user = \App\Models\User::withCount(['documents', 'orders', 'blogs'])->findOrFail(auth()->id());
		$documentsCount = $user->documents_count;
		$ordersCount = $user->orders_count;
		$blogsCount = $user->blogs_count;

		// Filters similar to admin UI
		$q = trim((string)$request->query('q', ''));
		$status = $request->query('status'); // all|pending|dang_giao|da_nhan|huy
		$ordersQuery = \App\Models\Order::with('document')
			->where('user_id', $user->id)
			->latest();
		if ($q !== '') {
			$ordersQuery->whereHas('document', function($qq) use ($q){
				$qq->where('ten_tai_lieu', 'like', "%$q%");
			});
		}
		if ($status && in_array($status, ['pending','dang_giao','da_nhan','huy'])) {
			$ordersQuery->where('trang_thai', $status);
		}
	$orders = $ordersQuery->paginate(10);

	// Saved documents count
	$savedDocumentsCount = 0;
	$savedBlogsCount = 0;
	if (method_exists($user, 'savedDocuments')) {
		$savedDocumentsCount = $user->savedDocuments()->count();
	}
	if (method_exists($user, 'savedBlogs')) {
		$savedBlogsCount = $user->savedBlogs()->count();
	}

	// If admin, prepare users list (existing + newest)
	$users = null; $recentUsers = null; $userSearch = trim((string)$request->query('user_q',''));
	$__me = auth()->user();
	if ($__me && (($__me->role ?? null) === 'admin')) {
		$usersQuery = \App\Models\User::query()->whereIn('role', ['student','admin']);
		if ($userSearch !== '') {
			$usersQuery->where(function($qq) use ($userSearch){
				$qq->where('name','like',"%$userSearch%")
					->orWhere('email','like',"%$userSearch%")
					->orWhere('khoa','like',"%$userSearch%");
			});
		}
		$users = $usersQuery->latest()->paginate(10)->appends(['user_q' => $userSearch]);
		$recentUsers = \App\Models\User::whereIn('role', ['student','admin'])->latest()->take(5)->get();
	}

	return view('profile.index', compact('user','documentsCount','ordersCount','blogsCount','savedDocumentsCount','savedBlogsCount','orders','q','status','users','recentUsers','userSearch'));
	}

	public function edit()
	{
		$user = \App\Models\User::findOrFail(auth()->id());
		return view('profile.edit', compact('user'));
	}

	public function update(Request $request)
	{
		$userId = auth()->id();
		$data = $request->validate([
			'name' => 'required|string|max:255',
			'ma_sv' => 'nullable|string|max:50',
			'ma_lop' => 'nullable|string|max:50',
			'khoa' => 'nullable|string|max:255',
			'nganh' => 'nullable|string|max:255',
			'anh_the' => 'nullable|image|max:4096',
		]);
		if ($request->hasFile('anh_the')) {
			$data['anh_the'] = $request->file('anh_the')->store('avatars', 'public');
		}
		\App\Models\User::where('id', $userId)->update($data);
		return redirect()->route('profile.index')->with('success', 'Đã cập nhật hồ sơ');
	}

	public function documents()
	{
		$documents = \App\Models\Document::where('user_id', auth()->id())->latest()->paginate(10);
		return view('profile.documents', compact('documents'));
	}

	public function savedDocuments()
	{
		$user = \App\Models\User::findOrFail(auth()->id());
		$saved = $user->savedDocuments()->with(['user','khoa','nganh','mon'])->latest('document_saves.created_at')->paginate(10);
		return view('profile.saved-documents', compact('saved'));
	}

	public function savedBlogs()
	{
		$user = \App\Models\User::findOrFail(auth()->id());
		$saved = $user->savedBlogs()->with('user')->latest('blog_saves.created_at')->paginate(10);
		return view('profile.saved-blogs', compact('saved'));
	}

	public function blogs()
	{
		$blogs = \App\Models\Blog::where('user_id', auth()->id())->latest()->paginate(10);
		return view('profile.blogs', compact('blogs'));
	}

	public function orders()
	{
		$orders = \App\Models\Order::where('user_id', auth()->id())->latest()->paginate(10);
		return view('profile.orders', compact('orders'));
	}

	// Lock/unlock own account (for demo UX parity)
	public function lock()
	{
		abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
		$user = \App\Models\User::findOrFail(auth()->id());
		$user->status = 'locked';
		$user->save();
		return back()->with('success', 'Tài khoản đã được khóa tạm thời');
	}

	public function unlock()
	{
		abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
		$user = \App\Models\User::findOrFail(auth()->id());
		$user->status = 'active';
		$user->save();
		return back()->with('success', 'Tài khoản đã được mở khóa');
	}

	// Only admin can update order status from profile
	public function updateOrderStatus(Request $request, \App\Models\Order $order)
	{
		abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
		$data = $request->validate([
			'trang_thai' => 'required|in:pending,dang_giao,da_nhan,huy'
		]);
		$order->trang_thai = $data['trang_thai'];
		$order->save();
		return back()->with('success', 'Đã cập nhật trạng thái đơn hàng');
	}
}


<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
	public function index()
	{
		$blogs = Blog::with('user')->latest()->paginate(10);
		return view('blogs.index', compact('blogs'));
	}

	public function create()
	{
		return view('blogs.create');
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'tieu_de' => 'required|string|max:255',
			'noi_dung' => 'required|string',
			'hinh_anh' => 'nullable|image|max:4096',
		]);

		if ($request->hasFile('hinh_anh')) {
			$data['hinh_anh'] = $request->file('hinh_anh')->store('blogs', 'public');
		}

		$data['user_id'] = auth()->id();
		$blog = Blog::create($data);
		return redirect()->route('blogs.show', $blog)->with('status', 'Đăng blog thành công');
	}

	public function show(Blog $blog)
	{
		$blog->load(['user', 'comments.user']);
		return view('blogs.show', compact('blog'));
	}

	public function addComment(Request $request, Blog $blog)
	{
		$request->validate(['noi_dung' => 'required|string']);
		BlogComment::create([
			'blog_id' => $blog->id,
			'user_id' => auth()->id(),
			'noi_dung' => $request->input('noi_dung'),
		]);
		return back()->with('status', 'Đã bình luận');
	}

	public function edit(Blog $blog)
	{
		abort_if($blog->user_id !== auth()->id(), 403);
		return view('blogs.edit', compact('blog'));
	}

	public function update(Request $request, Blog $blog)
	{
		// If admin is updating moderation status, allow updating 'trang_thai'
	if (auth()->check() && auth()->user()->role === 'admin' && $request->has('trang_thai')) {
			$request->validate(['trang_thai' => 'required|in:pending,approved,hidden']);
			$blog->update(['trang_thai' => $request->input('trang_thai')]);
			return back()->with('success', 'Cập nhật trạng thái blog thành công');
		}

		// Otherwise normal owner update
		abort_if($blog->user_id !== auth()->id(), 403);
		$data = $request->validate([
			'tieu_de' => 'required|string|max:255',
			'noi_dung' => 'required|string',
			'hinh_anh' => 'nullable|image|max:4096',
		]);
		if ($request->hasFile('hinh_anh')) {
			$data['hinh_anh'] = $request->file('hinh_anh')->store('blogs', 'public');
		}
		$blog->update($data);
		return redirect()->route('blogs.show', $blog)->with('status', 'Đã cập nhật');
	}

	public function destroy(Blog $blog)
	{
		abort_if($blog->user_id !== auth()->id(), 403);
		$blog->delete();
		return redirect()->route('blogs.index')->with('status', 'Đã xóa blog');
	}
}


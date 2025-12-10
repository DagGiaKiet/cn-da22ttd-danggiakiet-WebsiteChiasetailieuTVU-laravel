<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class AdminBlogController extends Controller
{
	public function index()
	{
		$blogs = Blog::with('user')->latest()->paginate(20);
		return view('admin.blogs.index', compact('blogs'));
	}
}


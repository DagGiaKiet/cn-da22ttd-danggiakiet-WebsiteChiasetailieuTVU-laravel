<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class AdminBlogController extends Controller
{
	public function index(\Illuminate\Http\Request $request)
	{
		$query = Blog::with('user');

        if ($request->has('search') && $request->search != '') {
             $search = $request->search;
             $query->where(function($q) use ($search) {
                 $q->where('tieu_de', 'LIKE', "%{$search}%")
                   ->orWhere('id', $search);
             });
        }

		$blogs = $query->latest()->paginate(20);

        if ($request->ajax()) {
            return view('admin.blogs.table_rows', compact('blogs'))->render();
        }

		return view('admin.blogs.index', compact('blogs'));
	}
}


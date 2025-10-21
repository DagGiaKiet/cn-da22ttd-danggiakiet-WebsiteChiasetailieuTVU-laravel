<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Document;
use App\Models\Blog;

class AdminDashboardController extends Controller
{
	public function index()
	{
		return view('admin.dashboard', [
			'users' => User::count(),
			'orders' => Order::count(),
			'documents' => Document::count(),
			'blogs' => Blog::count(),
		]);
	}
}

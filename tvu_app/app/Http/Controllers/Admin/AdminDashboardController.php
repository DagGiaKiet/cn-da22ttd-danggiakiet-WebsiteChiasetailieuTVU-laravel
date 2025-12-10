<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Document;
use App\Models\Blog;
use App\Models\Contact;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
	public function index()
	{
		$users = User::count();
		$orders = Order::with('document')->get();
		$documents = Document::count();
		$blogs = Blog::count();
		$leads = Contact::count();

		$completedOrders = $orders->where('trang_thai', 'da_nhan');
		$revenue = $completedOrders->sum(function ($o) {
			return (int) ($o->document->gia ?? 0);
		});
		$ordersCount = $orders->count();
		$completedCount = $completedOrders->count();
		$conversionRate = $ordersCount > 0 ? round($completedCount * 100 / $ordersCount, 0) : 0;

		// Build last 12 months labels and series
		$labels = [];
		$ordersSeries = [];
		$revenueSeries = [];
		$start = Carbon::now()->startOfMonth()->subMonths(11);
		for ($i = 0; $i < 12; $i++) {
			$month = (clone $start)->addMonths($i);
			$key = $month->format('Y-m');
			$labels[] = $month->format('M Y');
		}

		$ordersLastYear = Order::with('document')
			->where('created_at', '>=', $start)
			->get()
			->groupBy(function ($o) {
				return $o->created_at->format('Y-m');
			});

		foreach ($labels as $idx => $label) {
			// map back to Y-m key
			$monthKey = $start->copy()->addMonths($idx)->format('Y-m');
			$monthOrders = $ordersLastYear->get($monthKey, collect());
			$ordersSeries[] = $monthOrders->count();
			$revenueSeries[] = $monthOrders->sum(function ($o) {
				return (int) ($o->document->gia ?? 0);
			});
		}

		// Recent activities (last 5 orders)
		$recentOrders = Order::with(['user', 'document'])
			->latest()
			->take(5)
			->get();

		return view('admin.dashboard', compact(
			'users', 'documents', 'blogs',
			'ordersCount', 'leads', 'revenue', 'conversionRate',
			'labels', 'ordersSeries', 'revenueSeries', 'recentOrders'
		));
	}
}

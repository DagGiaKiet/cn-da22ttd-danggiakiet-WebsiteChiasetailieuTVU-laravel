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
    // Trang chủ quản trị (Dashboard)
	public function index()
	{
		$users = User::count();
		$orders = Order::with('document')->get();
		$documents = Document::count();
		$blogs = Blog::count();
		$leads = Contact::count();
        $contactsCount = Contact::count();

		$completedOrders = $orders->where('trang_thai', 'da_nhan');
		$revenue = $completedOrders->sum(function ($o) {
			return (int) ($o->document->gia ?? 0);
		});
		$ordersCount = $orders->count();
		$completedCount = $completedOrders->count();
		$conversionRate = $ordersCount > 0 ? round($completedCount * 100 / $ordersCount, 0) : 0;

		// Xây dựng nhãn và dữ liệu cho 12 tháng qua
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
			// Ánh xạ lại khóa định dạng Y-m
			$monthKey = $start->copy()->addMonths($idx)->format('Y-m');
			$monthOrders = $ordersLastYear->get($monthKey, collect());
			$ordersSeries[] = $monthOrders->count();
			$revenueSeries[] = $monthOrders->sum(function ($o) {
				return (int) ($o->document->gia ?? 0);
			});
		}

		// Hoạt động gần đây (5 đơn hàng mới nhất)
		$recentOrders = Order::with(['user', 'document'])
			->latest()
			->take(5)
			->get();

		return view('admin.dashboard', compact(
			'users', 'documents', 'blogs',
			'ordersCount', 'leads', 'revenue', 'conversionRate', 'contactsCount',
			'labels', 'ordersSeries', 'revenueSeries', 'recentOrders'
		));
	}

    // Thống kê nhanh
    public function stats()
    {
        $orders = Order::with('document')->get();
        $leads = Contact::count();
        $contactsCount = Contact::count(); // Hiện tại giống như số lượng lead

        $completedOrders = $orders->where('trang_thai', 'da_nhan');
        $revenue = $completedOrders->sum(function ($o) {
            return (int) ($o->document->gia ?? 0);
        });
        
        $ordersCount = $orders->count();
        $completedCount = $completedOrders->count();
        $conversionRate = $ordersCount > 0 ? round($completedCount * 100 / $ordersCount, 0) : 0;

        return response()->json([
            'revenue' => number_format($revenue, 0, ',', '.') . ' đ',
            'orders' => number_format($ordersCount),
            'leads' => number_format($leads),
            'conversionRate' => $conversionRate . ' %',
            'contacts' => number_format($contactsCount)
        ]);
    }

    // Tìm kiếm toàn cầu cho phần admin
    public function globalSearch(\Illuminate\Http\Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            return response()->json([]);
        }

        $results = [];

        // 1. Người dùng
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('ma_sv', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name', 'email', 'role']);
        
        foreach ($users as $user) {
            $results[] = [
                'type' => 'Người dùng',
                'title' => $user->name,
                'subtitle' => $user->email . ' (' . $user->role . ')',
                'url' => route('admin.users.index', ['search' => $user->id]),
                'icon' => 'user'
            ];
        }

        // 2. Tài liệu
        $documents = Document::where('ten_tai_lieu', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get(['id', 'ten_tai_lieu']);

        foreach ($documents as $doc) {
            $results[] = [
                'type' => 'Tài liệu',
                'title' => $doc->ten_tai_lieu,
                'subtitle' => 'Tài liệu',
                'url' => route('admin.documents.index', ['search' => $doc->id]),
                'icon' => 'file'
            ];
        }

        // 3. Đơn hàng (Tìm theo ID hoặc tên người dùng)
        $orders = Order::with('user', 'document')
            ->where('id', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->limit(5)
            ->get();

        foreach ($orders as $order) {
            $results[] = [
                'type' => 'Đơn hàng',
                'title' => 'Đơn hàng #' . $order->id,
                'subtitle' => ($order->user->name ?? 'N/A') . ' - ' . ($order->document->ten_tai_lieu ?? 'N/A'),
                'url' => route('admin.orders.index', ['search' => $order->id]),
                'icon' => 'shopping-cart'
            ];
        }

        // 4. Bài viết (Blogs)
        $blogs = Blog::where('tieu_de', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get(['id', 'tieu_de']);
            
        foreach ($blogs as $blog) {
            $results[] = [
                'type' => 'Blog',
                'title' => $blog->tieu_de,
                'subtitle' => 'Bài viết',
                'url' => route('admin.blogs.index', ['search' => $blog->id]),
                'icon' => 'book-open'
            ];
        }

        return response()->json($results);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
	public function index(Request $request)
	{
		$query = Order::with(['document','user']);

        if ($request->has('search') && $request->search != '') {
             $search = $request->search;
             $query->where('id', 'LIKE', "%{$search}%")
                   ->orWhereHas('user', function($q) use ($search){
                       $q->where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%");
                   })
                   ->orWhereHas('document', function($q) use ($search){
                       $q->where('ten_tai_lieu', 'LIKE', "%{$search}%");
                   });
        }

		$orders = $query->latest()->paginate(20);

        if ($request->ajax()) {
            return view('admin.orders.table_rows', compact('orders'))->render();
        }

		return view('admin.orders.index', compact('orders'));
	}

	public function updateStatus(Request $request, Order $order)
	{
		$request->validate(['trang_thai' => 'required|in:pending,dang_giao,da_nhan,huy']);
		$order->update(['trang_thai' => $request->trang_thai]);
		return back()->with('status', 'Đã cập nhật trạng thái đơn hàng');
	}
}


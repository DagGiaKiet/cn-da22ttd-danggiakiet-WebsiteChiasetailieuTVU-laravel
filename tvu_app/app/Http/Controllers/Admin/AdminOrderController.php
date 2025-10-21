<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
	public function index()
	{
		$orders = Order::with(['document','user'])->latest()->paginate(20);
		return view('admin.orders.index', compact('orders'));
	}

	public function updateStatus(Request $request, Order $order)
	{
		$request->validate(['trang_thai' => 'required|in:pending,dang_giao,da_nhan,huy']);
		$order->update(['trang_thai' => $request->trang_thai]);
		return back()->with('status', 'Đã cập nhật trạng thái đơn hàng');
	}
}


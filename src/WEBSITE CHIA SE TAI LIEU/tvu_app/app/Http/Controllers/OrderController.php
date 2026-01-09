<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
	public function index()
	{
		$query = Order::with('document')->where('user_id', auth()->id());
		$status = request('status');
		$allowed = ['pending','dang_giao','da_nhan','huy'];
		if ($status && in_array($status, $allowed, true)) {
			$query->where('trang_thai', $status);
		}
		$orders = $query->latest()->paginate(10);
		return view('orders.index', compact('orders'));
	}

	public function show(Order $order)
	{
		abort_if($order->user_id !== auth()->id(), 403);
		$order->load('document.user');
		return view('orders.show', compact('order'));
	}

	public function cancel(Order $order)
	{
		// Only owner can cancel and only when pending
		abort_if($order->user_id !== auth()->id(), 403);
		if ($order->trang_thai !== 'pending') {
			return back()->with('status', 'Chỉ có thể hủy đơn khi đang ở trạng thái Chờ xử lý');
		}
		$order->trang_thai = 'huy';
		$order->save();

        // Revert document status to available
        if ($order->document) {
            $order->document->update(['trang_thai' => 'available']);
        }

		return back()->with('status', 'Đã hủy đơn hàng');
	}
}


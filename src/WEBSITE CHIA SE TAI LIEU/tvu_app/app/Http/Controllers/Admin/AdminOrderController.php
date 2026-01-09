<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Danh sách đơn hàng
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

    // Cập nhật trạng thái đơn hàng
	public function updateStatus(Request $request, Order $order)
	{
		$request->validate(['trang_thai' => 'required|in:pending,dang_giao,da_nhan,huy']);
        
        $oldStatus = $order->trang_thai;
        $newStatus = $request->trang_thai;

		$order->update(['trang_thai' => $newStatus]);

        // Logic check:
        // If changing TO 'huy', make document available.
        // If changing FROM 'huy' TO active, make document sold (if available).
        
        if ($newStatus === 'huy' && $oldStatus !== 'huy') {
            if ($order->document) {
                $order->document->update(['trang_thai' => 'available']);
            }
        } elseif ($oldStatus === 'huy' && $newStatus !== 'huy') {
            if ($order->document) {
                // Check availability effectively
                if ($order->document->trang_thai === 'available') {
                    $order->document->update(['trang_thai' => 'sold']);
                } else {
                    // Slight edge case: Admin reactivates an order for a document that was bought by someone else in the meantime.
                    // Ideally we should warn, but for now let's just leave it sold (it's already sold).
                    // Or we could force it? Let's just update to sold to be consistent.
                    $order->document->update(['trang_thai' => 'sold']); 
                }
            }
        }

		return back()->with('status', 'Đã cập nhật trạng thái đơn hàng');
	}
}


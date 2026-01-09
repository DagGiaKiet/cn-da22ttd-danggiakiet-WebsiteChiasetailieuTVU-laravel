<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Document;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
	public function index()
	{
		$items = Cart::with('document')->where('user_id', auth()->id())->get();
		return view('cart.index', compact('items'));
	}

	public function add(Document $document)
	{
		Cart::firstOrCreate([
			'user_id' => auth()->id(),
			'document_id' => $document->id,
		]);
		return back()->with('status', 'Đã thêm vào giỏ hàng');
	}

	public function remove(Cart $cart)
	{
		abort_if($cart->user_id !== auth()->id(), 403);
		$cart->delete();
		
		if (request()->wantsJson()) {
			return response()->json(['success' => true]);
		}
		
		return back()->with('status', 'Đã xóa khỏi giỏ hàng');
	}

	public function checkout(Request $request)
	{
		$items = Cart::with('document')->where('user_id', auth()->id())->get();
        if ($items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng trống');
        }

		foreach ($items as $item) {
            // Check if document is still available
            if ($item->document->trang_thai !== 'available') {
                return back()->with('error', 'Tài liệu "' . $item->document->ten_tai_lieu . '" đã hết hàng. Vui lòng xóa khỏi giỏ hàng.');
            }

			Order::create([
				'user_id' => auth()->id(),
				'document_id' => $item->document_id,
				'trang_thai' => 'pending',
			]);

            // Update document status to sold
            $item->document->update(['trang_thai' => 'sold']);
		}
		Cart::where('user_id', auth()->id())->delete();
		return redirect()->route('orders.index')->with('status', 'Đặt hàng thành công');
	}
}


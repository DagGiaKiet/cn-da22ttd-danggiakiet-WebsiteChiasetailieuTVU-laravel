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
		$items = Cart::where('user_id', auth()->id())->get();
		foreach ($items as $item) {
			Order::create([
				'user_id' => auth()->id(),
				'document_id' => $item->document_id,
				'trang_thai' => 'pending',
			]);
		}
		Cart::where('user_id', auth()->id())->delete();
		return redirect()->route('orders.index')->with('status', 'Đặt hàng thành công');
	}
}


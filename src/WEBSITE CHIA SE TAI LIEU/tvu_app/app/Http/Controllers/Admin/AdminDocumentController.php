<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;

class AdminDocumentController extends Controller
{
	public function index(\Illuminate\Http\Request $request)
	{
		$query = Document::with('user');

        if ($request->has('search') && $request->search != '') {
             $search = $request->search;
             $query->where(function($q) use ($search) {
                 $q->where('ten_tai_lieu', 'LIKE', "%{$search}%")
                   ->orWhere('id', $search);
             });
        }

		$documents = $query->latest()->paginate(20);

        if ($request->ajax()) {
            return view('admin.documents.table_rows', compact('documents'))->render();
        }

		return view('admin.documents.index', compact('documents'));
	}

    public function updateStatus(\Illuminate\Http\Request $request, Document $document)
    {
        $request->validate([
            'trang_thai' => 'required|in:available,sold'
        ]);
        
        $document->trang_thai = $request->trang_thai;
        $document->save();
        
        return back()->with('success', 'Đã cập nhật trạng thái tài liệu: ' . ($request->trang_thai === 'available' ? 'Còn hàng' : 'Hết hàng'));
    }
}

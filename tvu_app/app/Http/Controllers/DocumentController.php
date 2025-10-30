<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Khoa;
use App\Models\Nganh;
use App\Models\Mon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
	public function index()
	{
		$documents = Document::with(['khoa','nganh','mon','user'])->latest()->paginate(12);
		$savedIds = collect();
		if (auth()->check()) {
			$savedIds = DB::table('document_saves')->where('user_id', auth()->id())->pluck('document_id');
		}
		return view('documents.index', compact('documents','savedIds'));
	}

	public function create()
	{
		$khoas = Khoa::orderBy('ten_khoa')->get();
		$nganhs = Nganh::orderBy('ten_nganh')->get();
		$mons = Mon::orderBy('ten_mon')->get();
		return view('documents.create', compact('khoas','nganhs','mons'));
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'ten_tai_lieu' => 'required|string|max:255',
			'mo_ta' => 'nullable|string',
			'hinh_anh' => 'nullable|image|max:4096',
			'gia' => 'required|numeric|min:0',
			'loai' => 'required|in:ban,cho',
			'khoa_id' => 'required|exists:khoas,id',
			'nganh_id' => 'required|exists:nganhs,id',
			'mon_id' => 'required|exists:mons,id',
		]);

		if ($request->hasFile('hinh_anh')) {
			$data['hinh_anh'] = $request->file('hinh_anh')->store('documents', 'public');
		}

		$data['user_id'] = auth()->id();
		$data['trang_thai'] = 'available';

		$document = Document::create($data);
		return redirect()->route('documents.show', $document)->with('status', 'Đăng tài liệu thành công');
	}

	public function show(Document $document)
	{
		$document->load(['khoa','nganh','mon','user']);
		$saved = false;
		if (auth()->check()) {
			$saved = DB::table('document_saves')->where(['document_id'=>$document->id,'user_id'=>auth()->id()])->exists();
		}
		return view('documents.show', compact('document','saved'));
	}

	public function edit(Document $document)
	{
		abort_if($document->user_id !== auth()->id(), 403);
		$khoas = Khoa::orderBy('ten_khoa')->get();
		$nganhs = Nganh::orderBy('ten_nganh')->get();
		$mons = Mon::orderBy('ten_mon')->get();
		return view('documents.edit', compact('document','khoas','nganhs','mons'));
	}

	public function update(Request $request, Document $document)
	{
		// Admin moderation path
		if (auth()->check() && auth()->user()->role === 'admin' && $request->has('trang_thai_duyet')) {
			$request->validate(['trang_thai_duyet' => 'required|in:pending,approved,hidden']);
			$document->update(['trang_thai_duyet' => $request->input('trang_thai_duyet')]);
			return back()->with('success', 'Cập nhật trạng thái tài liệu thành công');
		}

		abort_if($document->user_id !== auth()->id(), 403);
		$data = $request->validate([
			'ten_tai_lieu' => 'required|string|max:255',
			'mo_ta' => 'nullable|string',
			'hinh_anh' => 'nullable|image|max:4096',
			'gia' => 'required|numeric|min:0',
			'loai' => 'required|in:ban,cho',
			'khoa_id' => 'required|exists:khoas,id',
			'nganh_id' => 'required|exists:nganhs,id',
			'mon_id' => 'required|exists:mons,id',
			'trang_thai' => 'required|in:available,sold',
		]);

		if ($request->hasFile('hinh_anh')) {
			$data['hinh_anh'] = $request->file('hinh_anh')->store('documents', 'public');
		}

		$document->update($data);
		return redirect()->route('documents.show', $document)->with('status', 'Cập nhật tài liệu thành công');
	}

	public function destroy(Document $document)
	{
		abort_if($document->user_id !== auth()->id(), 403);
		$document->delete();
		return redirect()->route('documents.index')->with('status', 'Đã xóa tài liệu');
	}

	public function toggleSave(Document $document)
	{
		abort_unless(auth()->check(), 403);
		$uid = auth()->id();
		$exists = DB::table('document_saves')->where(['document_id'=>$document->id,'user_id'=>$uid])->exists();
		if ($exists) {
			DB::table('document_saves')->where(['document_id'=>$document->id,'user_id'=>$uid])->delete();
		} else {
			DB::table('document_saves')->insert(['document_id'=>$document->id,'user_id'=>$uid,'created_at'=>now(),'updated_at'=>now()]);
		}
		return back();
	}
}


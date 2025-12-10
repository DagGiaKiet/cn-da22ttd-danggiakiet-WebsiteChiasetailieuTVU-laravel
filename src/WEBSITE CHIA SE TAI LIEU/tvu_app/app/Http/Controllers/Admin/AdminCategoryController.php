<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Khoa;
use App\Models\Nganh;
use App\Models\Mon;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
	public function index()
	{
		return view('admin.categories.index', [
			'khoas' => Khoa::orderBy('ten_khoa')->get(),
			'nganhs' => Nganh::with('khoa')->orderBy('ten_nganh')->get(),
			'mons' => Mon::with('nganh.khoa')->orderBy('ten_mon')->get(),
		]);
	}

	public function indexKhoas()
	{
		$khoas = Khoa::orderBy('ten_khoa')->paginate(20);
		return view('admin.categories.khoas', compact('khoas'));
	}

	public function storeKhoa(Request $request)
	{
		$data = $request->validate(['ten_khoa' => 'required|string|max:255', 'mo_ta' => 'nullable|string']);
		Khoa::create($data);
		return back()->with('status', 'Đã thêm khoa');
	}

	public function destroyKhoa(Khoa $khoa)
	{
		$khoa->delete();
		return back()->with('status', 'Đã xóa khoa');
	}

	public function indexNganhs()
	{
		$nganhs = Nganh::with('khoa')->orderBy('ten_nganh')->paginate(20);
		return view('admin.categories.nganhs', compact('nganhs'));
	}

	public function storeNganh(Request $request)
	{
		$data = $request->validate([
			'ten_nganh' => 'required|string|max:255',
			'khoa_id' => 'required|exists:khoas,id',
			'mo_ta' => 'nullable|string'
		]);
		Nganh::create($data);
		return back()->with('status', 'Đã thêm ngành');
	}

	public function destroyNganh(Nganh $nganh)
	{
		$nganh->delete();
		return back()->with('status', 'Đã xóa ngành');
	}

	public function indexMons()
	{
		$mons = Mon::with('nganh.khoa')->orderBy('ten_mon')->paginate(20);
		return view('admin.categories.mons', compact('mons'));
	}

	public function storeMon(Request $request)
	{
		$data = $request->validate([
			'ten_mon' => 'required|string|max:255',
			'nganh_id' => 'required|exists:nganhs,id',
			'mo_ta' => 'nullable|string'
		]);
		Mon::create($data);
		return back()->with('status', 'Đã thêm môn');
	}

	public function destroyMon(Mon $mon)
	{
		$mon->delete();
		return back()->with('status', 'Đã xóa môn');
	}
}


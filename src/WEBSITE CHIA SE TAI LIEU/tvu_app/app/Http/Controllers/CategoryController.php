<?php

namespace App\Http\Controllers;

use App\Models\Khoa;
use App\Models\Nganh;
use App\Models\Mon;
use App\Models\Document;

class CategoryController extends Controller
{
	public function index()
	{
		$khoas = Khoa::orderBy('ten_khoa')->get();
		return view('categories.index', compact('khoas'));
	}

	public function showKhoa(Khoa $khoa)
	{
		$nganhs = $khoa->nganhs()->orderBy('ten_nganh')->get();
		return view('categories.khoa', compact('khoa', 'nganhs'));
	}

	public function showNganh(Nganh $nganh)
	{
		$mons = $nganh->mons()->orderBy('ten_mon')->get();
		return view('categories.nganh', compact('nganh', 'mons'));
	}

	public function showMon(Mon $mon)
	{
		$documents = Document::where('mon_id', $mon->id)->where('trang_thai', 'available')->latest()->paginate(12);
		return view('categories.mon', compact('mon', 'documents'));
	}
}


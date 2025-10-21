<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Khoa;
use App\Models\Mon;
use App\Models\Nganh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicCategoryController extends Controller
{
    public function khoas()
    {
        return response()->json(
            Khoa::query()->select('id','ten_khoa')->orderBy('ten_khoa')->get()
        );
    }

    public function nganhs(Request $request)
    {
        $khoaId = $request->query('khoa_id');
        abort_if(!$khoaId, 400, 'khoa_id is required');
        return response()->json(
            Nganh::query()->where('khoa_id', $khoaId)->select('id','ten_nganh')->orderBy('ten_nganh')->get()
        );
    }

    public function mons(Request $request)
    {
        $nganhId = $request->query('nganh_id');
        abort_if(!$nganhId, 400, 'nganh_id is required');
        return response()->json(
            Mon::query()->where('nganh_id', $nganhId)->select('id','ten_mon')->orderBy('ten_mon')->get()
        );
    }

    public function documents(Request $request)
    {
        $monId = $request->query('mon_id');
        abort_if(!$monId, 400, 'mon_id is required');
        $docs = Document::query()
            ->where('mon_id', $monId)
            ->where('trang_thai', 'available')
            ->select('id','ten_tai_lieu','mo_ta','gia','loai','hinh_anh')
            ->orderByDesc('id')
            ->get()
            ->map(function ($d) {
                $d->hinh_anh_url = ($d->hinh_anh && Storage::disk('public')->exists($d->hinh_anh))
                    ? asset('storage/'.$d->hinh_anh)
                    : null;
                return $d;
            });
        return response()->json($docs);
    }
}

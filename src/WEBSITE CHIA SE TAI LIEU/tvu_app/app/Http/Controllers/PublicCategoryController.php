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
        // Flexible filters to support the new UI
        $khoaId = $request->query('khoa_id');
        $nganhId = $request->query('nganh_id');
        $monId = $request->query('mon_id');
        $queryText = $request->query('q');
        $loai = $request->query('loai'); // 'cho' | 'ban'
        $year = $request->query('year');
        $sort = $request->query('sort', 'new'); // new | price_asc | price_desc

        $q = Document::query()
            ->with([
                'khoa:id,ten_khoa',
                'nganh:id,ten_nganh',
                'mon:id,ten_mon'
            ])
            ->where('trang_thai', 'available');

        if ($khoaId) $q->where('khoa_id', $khoaId);
        if ($nganhId) $q->where('nganh_id', $nganhId);
        if ($monId) $q->where('mon_id', $monId);
        if ($loai) $q->where('loai', $loai);
        if ($year) $q->whereYear('created_at', (int)$year);
        if ($queryText) {
            $like = '%'.$queryText.'%';
            $q->where(function($sub) use ($like){
                $sub->where('ten_tai_lieu', 'like', $like)
                    ->orWhere('mo_ta', 'like', $like);
            });
        }

        if ($sort === 'price_asc') $q->orderBy('gia', 'asc');
        elseif ($sort === 'price_desc') $q->orderBy('gia', 'desc');
        else $q->orderByDesc('created_at');

        $docs = $q->select('id','ten_tai_lieu','mo_ta','gia','loai','hinh_anh','khoa_id','nganh_id','mon_id','user_id','created_at')
            ->with('user:id,name,email')
            ->get()
            ->map(function ($d) {
                $d->hinh_anh_url = ($d->hinh_anh && Storage::disk('public')->exists($d->hinh_anh))
                    ? asset('storage/'.$d->hinh_anh)
                    : null;
                $d->khoa_ten = optional($d->khoa)->ten_khoa;
                $d->nganh_ten = optional($d->nganh)->ten_nganh;
                $d->mon_ten = optional($d->mon)->ten_mon;
                $d->created_date = optional($d->created_at)->format('m/Y');
                $d->user_name = optional($d->user)->name;
                $d->user_email = optional($d->user)->email;
                return $d;
            });
        return response()->json($docs);
    }
}

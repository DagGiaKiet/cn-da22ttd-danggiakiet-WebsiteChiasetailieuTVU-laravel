<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_tai_lieu',
        'mo_ta',
        'hinh_anh',
        'gia',
        'loai',
        'khoa_id',
        'nganh_id',
        'mon_id',
        'user_id',
        'trang_thai',
        'trang_thai_duyet'
    ];

    /**
     * Get the user that owns the document
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the khoa
     */
    public function khoa()
    {
        return $this->belongsTo(Khoa::class);
    }

    /**
     * Get the nganh
     */
    public function nganh()
    {
        return $this->belongsTo(Nganh::class);
    }

    /**
     * Get the mon
     */
    public function mon()
    {
        return $this->belongsTo(Mon::class);
    }

    /**
     * Get orders for this document
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Users who saved/bookmarked this document
     */
    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'document_saves')->withTimestamps();
    }

    /**
     * Check if document is free
     */
    public function isFree()
    {
        return $this->loai === 'cho';
    }

    /**
     * Check if document is available
     */
    public function isAvailable()
    {
        return $this->trang_thai === 'available';
    }
}

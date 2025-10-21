<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mon extends Model
{
    use HasFactory;

    protected $fillable = ['ten_mon', 'nganh_id', 'mo_ta'];

    /**
     * Get the nganh that owns the mon
     */
    public function nganh()
    {
        return $this->belongsTo(Nganh::class);
    }

    /**
     * Get documents in this mon
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}

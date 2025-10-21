<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    use HasFactory;

    protected $fillable = ['ten_khoa', 'mo_ta'];

    /**
     * Get nganhs in this khoa
     */
    public function nganhs()
    {
        return $this->hasMany(Nganh::class);
    }

    /**
     * Get documents in this khoa
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}

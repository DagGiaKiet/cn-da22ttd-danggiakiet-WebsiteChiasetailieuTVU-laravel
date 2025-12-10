<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nganh extends Model
{
    use HasFactory;

    protected $fillable = ['ten_nganh', 'khoa_id', 'mo_ta'];

    /**
     * Get the khoa that owns the nganh
     */
    public function khoa()
    {
        return $this->belongsTo(Khoa::class);
    }

    /**
     * Get mons in this nganh
     */
    public function mons()
    {
        return $this->hasMany(Mon::class);
    }

    /**
     * Get documents in this nganh
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}

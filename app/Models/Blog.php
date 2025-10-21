<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'hinh_anh',
        'user_id'
    ];

    /**
     * Get the user that owns the blog
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get comments for the blog
     */
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
}

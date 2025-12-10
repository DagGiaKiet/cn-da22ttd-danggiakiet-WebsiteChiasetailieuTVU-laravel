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
        'user_id',
        'trang_thai'
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

    /**
     * Users who liked this blog
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'blog_likes')->withTimestamps();
    }

    /**
     * Users who saved/bookmarked this blog
     */
    public function saves()
    {
        return $this->belongsToMany(User::class, 'blog_saves')->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * // Các thuộc tính có thể gán hàng loạt.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ma_sv',
        'ma_lop',
        'khoa',
        'nganh',
        'anh_the',
        'avatar',
        'role',
        'status',
    ];

    /**
     * // Các thuộc tính nên được ẩn khi serialize.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * // Các thuộc tính nên được ép kiểu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * // Kiểm tra xem người dùng có phải là admin không
     */
    public function isAdmin()
    {
        // Chỉ tài khoản admin chính thức mới được coi là admin
        return $this->role === 'admin' && strtolower($this->email) === 'admin@st.tvu.edu.vn';
    }

    /**
     * // Kiểm tra xem người dùng có đang hoạt động (không bị khóa)
     */
    public function isActive(): bool
    {
        return ($this->status ?? 'active') === 'active';
    }

    /**
     * // Lấy các tài liệu được tải lên bởi người dùng
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * // Lấy các bài viết (blog) được tạo bởi người dùng
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * // Lấy các đơn hàng của người dùng
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * // Lấy các mục trong giỏ hàng
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get blog comments by user
     */
    public function blogComments()
    {
        return $this->hasMany(BlogComment::class);
    }

    /**
     * Documents this user saved/bookmarked
     */
    public function savedDocuments()
    {
        return $this->belongsToMany(Document::class, 'document_saves')->withTimestamps();
    }

    /**
     * Blogs this user saved/bookmarked
     */
    public function savedBlogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_saves')->withTimestamps();
    }
}

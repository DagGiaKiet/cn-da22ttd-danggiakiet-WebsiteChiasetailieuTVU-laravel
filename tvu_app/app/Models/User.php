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
     * The attributes that are mass assignable.
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
        'role',
    'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        // Chỉ tài khoản admin chính thức mới được coi là admin
        return $this->role === 'admin' && strtolower($this->email) === 'admin@st.tvu.edu.vn';
    }

    /**
     * Check if user is active (not locked)
     */
    public function isActive(): bool
    {
        return ($this->status ?? 'active') === 'active';
    }

    /**
     * Get documents uploaded by user
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get blogs created by user
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Get orders made by user
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get cart items
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
}

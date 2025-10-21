<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    /**
     * Determine if the user can view the blog.
     */
    public function view(?User $user, Blog $blog)
    {
        return true;
    }

    /**
     * Determine if the user can update the blog.
     */
    public function update(User $user, Blog $blog)
    {
        return $user->id === $blog->user_id || $user->isAdmin();
    }

    /**
     * Determine if the user can delete the blog.
     */
    public function delete(User $user, Blog $blog)
    {
        return $user->id === $blog->user_id || $user->isAdmin();
    }
}

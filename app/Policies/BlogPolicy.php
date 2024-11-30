<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Blog;

class BlogPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, Blog $blog)
    {
        return $user->role_id === 3 || $user->user_id === $blog->user_id; // Admin or Owner
    }

    public function delete(User $user, Blog $blog)
    {
        return $user->role_id === 3 || $user->user_id === $blog->user_id; // Admin or Owner
    }
}

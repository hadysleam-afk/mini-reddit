<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Update post
     */
    public function update(
        User $user,
        Post $post
    ): bool {
        return $user->id === $post->user_id;
    }

    /**
     * Delete post
     */
    public function delete(
        User $user,
        Post $post
    ): bool {
        return $user->id === $post->user_id;
    }
}
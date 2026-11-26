<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Update comment
     */
    public function update(
        User $user,
        Comment $comment
    ): bool {
        return $user->id === $comment->user_id;
    }

    /**
     * Delete comment
     */
    public function delete(
        User $user,
        Comment $comment
    ): bool {
        return $user->id === $comment->user_id;
    }
}
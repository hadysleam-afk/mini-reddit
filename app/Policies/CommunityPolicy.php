<?php

namespace App\Policies;

use App\Models\Community;
use App\Models\User;

class CommunityPolicy
{
    /**
     * هل المستخدم يستطيع تعديل الـ Community؟
     */
    public function update(
        User $user,
        Community $community
    ): bool {
        return $user->id === $community->user_id;
    }

    /**
     * هل المستخدم يستطيع حذف الـ Community؟
     */
    public function delete(
        User $user,
        Community $community
    ): bool {
        return $user->id === $community->user_id;
    }
}
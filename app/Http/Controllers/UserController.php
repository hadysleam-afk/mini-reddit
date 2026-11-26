<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()
            ->with('community')
            ->withCount(['likedBy', 'comments'])
            ->latest()
            ->paginate(10);

        return view('users.show', compact('user', 'posts'));
    }
}
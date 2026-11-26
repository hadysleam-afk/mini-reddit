<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Get IDs of communities the user joined
        |--------------------------------------------------------------------------
        */

        $communityIds = $user
            ->joinedCommunities()
            ->pluck('communities.id');


        /*
        |--------------------------------------------------------------------------
        | Get Feed Posts
        |--------------------------------------------------------------------------
        */

        $posts = Post::with([
                'user',
                'community'
            ])
            ->withCount([
                'likedBy',
                'comments'
            ])
            ->where(function ($query) use ($user, $communityIds) {

                /*
                | Posts from my joined communities
                */

                $query->whereIn(
                    'community_id',
                    $communityIds
                );


                /*
                | OR my own profile posts
                */

                $query->orWhere(function ($query) use ($user) {

                    $query->where(
                        'user_id',
                        $user->id
                    )
                    ->whereNull(
                        'community_id'
                    );

                });

            })
            ->latest()
            ->paginate(10);

        return view(
            'home',
            compact('posts')
        );
    }
}
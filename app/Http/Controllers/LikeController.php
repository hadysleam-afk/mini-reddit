<?php

namespace App\Http\Controllers;

use App\Models\Post;

class LikeController extends Controller
{
    /**
     * Like a post
     */
    public function store(Post $post)
    {
        $alreadyLiked = $post
            ->likedBy()
            ->whereKey(auth()->id())
            ->exists();


        if (!$alreadyLiked) {

            $post
                ->likedBy()
                ->attach(auth()->id());
        }


        return back()
            ->with(
                'success',
                'Post liked.'
            );
    }


    /**
     * Unlike a post
     */
    public function destroy(Post $post)
    {
        $post
            ->likedBy()
            ->detach(auth()->id());


        return back()
            ->with(
                'success',
                'Post unliked.'
            );
    }
}
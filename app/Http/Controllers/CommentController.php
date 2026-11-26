<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a new comment
     */
    public function store(
        Request $request,
        Post $post
    ) {
        $validated = $request->validate([
            'content' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);


        Comment::create([
            'user_id' => auth()->id(),

            'post_id' => $post->id,

            'content' => $validated['content'],
        ]);


        return back()
            ->with(
                'success',
                'Comment added successfully.'
            );
    }


    /**
     * Show edit form
     */
    public function edit(Comment $comment)
    {
        $this->authorize(
            'update',
            $comment
        );


        return view(
            'comments.edit',
            compact('comment')
        );
    }


    /**
     * Update comment
     */
    public function update(
        Request $request,
        Comment $comment
    ) {
        $this->authorize(
            'update',
            $comment
        );


        $validated = $request->validate([
            'content' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);


        $comment->content =
            $validated['content'];

        $comment->save();


        return redirect()
            ->route(
                'posts.show',
                $comment->post
            )
            ->with(
                'success',
                'Comment updated successfully.'
            );
    }


    /**
     * Delete comment
     */
    public function destroy(
        Comment $comment
    ) {
        $this->authorize(
            'delete',
            $comment
        );


        $post = $comment->post;


        $comment->delete();


        return redirect()
            ->route(
                'posts.show',
                $post
            )
            ->with(
                'success',
                'Comment deleted successfully.'
            );
    }
}
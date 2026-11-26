<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display all posts.
     */
    public function index()
    {
        $posts = Post::with([
                'user',
                'community'
            ])
            ->withCount([
                'likedBy',
                'comments'
            ])
            ->latest()
            ->paginate(10);

        return view(
            'posts.index',
            compact('posts')
        );
    }


    /**
     * Show the form for creating a new post.
     */
 public function create(Request $request)
{
    $communities = auth()->user()
        ->joinedCommunities()
        ->latest()
        ->get();

    $selectedCommunity = null;

    if ($request->filled('community')) {

        $selectedCommunity = Community::findOrFail(
            $request->community
        );

        $isMember = $selectedCommunity
            ->members()
            ->whereKey(auth()->id())
            ->exists();

        if (!$isMember) {
            abort(403);
        }
    }

    return view(
        'posts.create',
        compact(
            'communities',
            'selectedCommunity'
        )
    );
}

    /**
     * Store a newly created post.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'content' => [
                'required',
                'string',
                'max:10000',
            ],

            'community_id' => [
                'nullable',
                'integer',
                'exists:communities,id',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | If post belongs to a Community
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['community_id'])) {

            $community = Community::findOrFail(
                $validated['community_id']
            );


            /*
            |--------------------------------------------------------------------------
            | Check membership
            |--------------------------------------------------------------------------
            */

            $isMember = $community
                ->members()
                ->whereKey(auth()->id())
                ->exists();


            /*
            |--------------------------------------------------------------------------
            | Prevent unauthorized posting
            |--------------------------------------------------------------------------
            */

            if (!$isMember) {

                return back()
                    ->withErrors([
                        'community_id' =>
                            'You must join the community before posting.'
                    ])
                    ->withInput();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Upload Post Image
        |--------------------------------------------------------------------------
        */

        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store(
                    'posts',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Post
        |--------------------------------------------------------------------------
        */

        $post = Post::create([
            'user_id' => auth()->id(),

            'community_id' =>
                $validated['community_id'] ?? null,

            'title' =>
                $validated['title'],

            'content' =>
                $validated['content'],

            'image' =>
                $imagePath,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect to Post
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'posts.show',
                $post
            )
            ->with(
                'success',
                'Post created successfully.'
            );
    }


    /**
     * Display a single post.
     */
    public function show(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | Load relationships
        |--------------------------------------------------------------------------
        */

        $post->load([
            'user',
            'community',
            'comments.user',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Count Likes and Comments
        |--------------------------------------------------------------------------
        */

        $post->loadCount([
            'likedBy',
            'comments',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Check if current user liked the post
        |--------------------------------------------------------------------------
        */

        $isLiked = $post
            ->likedBy()
            ->whereKey(auth()->id())
            ->exists();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'posts.show',
            compact(
                'post',
                'isLiked'
            )
        );
    }


    /**
     * Show the form for editing the post.
     */
public function edit(Post $post)
{
    $this->authorize('update', $post);

    $communities = auth()->user()
        ->joinedCommunities()
        ->latest()
        ->get();

    return view(
        'posts.edit',
        compact(
            'post',
            'communities'
        )
    );
}


    /**
     * Update the specified post.
     */
    public function update(
        Request $request,
        Post $post
    ) {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize(
            'update',
            $post
        );


        /*
        |--------------------------------------------------------------------------
        | Validate request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'content' => [
                'required',
                'string',
                'max:10000',
            ],

            'community_id' => [
                'nullable',
                'integer',
                'exists:communities,id',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Check Community Membership
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['community_id'])) {

            $community = Community::findOrFail(
                $validated['community_id']
            );


            $isMember = $community
                ->members()
                ->whereKey(auth()->id())
                ->exists();


            if (!$isMember) {

                return back()
                    ->withErrors([
                        'community_id' =>
                            'You must join the community before posting.'
                    ])
                    ->withInput();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Replace Post Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            /*
            | Delete old image
            */

            if ($post->image) {

                Storage::disk('public')
                    ->delete(
                        $post->image
                    );
            }


            /*
            | Store new image
            */

            $post->image = $request
                ->file('image')
                ->store(
                    'posts',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Post Data
        |--------------------------------------------------------------------------
        */

        $post->title =
            $validated['title'];

        $post->content =
            $validated['content'];

        $post->community_id =
            $validated['community_id'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $post->save();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'posts.show',
                $post
            )
            ->with(
                'success',
                'Post updated successfully.'
            );
    }


    /**
     * Remove the specified post.
     */
    public function destroy(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize(
            'delete',
            $post
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Post Image
        |--------------------------------------------------------------------------
        */

        if ($post->image) {

            Storage::disk('public')
                ->delete(
                    $post->image
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Post
        |--------------------------------------------------------------------------
        */

        $post->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'Post deleted successfully.'
            );
    }
}
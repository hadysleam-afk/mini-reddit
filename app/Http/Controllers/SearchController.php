<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Community;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));

        $users = collect();
        $communities = collect();
        $posts = collect();

        if ($query !== '') {

            $users = User::where('name', 'like', "%{$query}%")
                ->latest()
                ->limit(10)
                ->get();

            $communities = Community::where(function ($q) use ($query) {

                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");

            })
            ->latest()
            ->limit(10)
            ->get();

            $posts = Post::where(function ($q) use ($query) {

                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");

            })
            ->with([
                'user',
                'community'
            ])
            ->withCount([
                'likedBy',
                'comments'
            ])
            ->latest()
            ->limit(20)
            ->get();
        }

        return view('search.index', compact(
            'query',
            'users',
            'communities',
            'posts'
        ));
    }
}
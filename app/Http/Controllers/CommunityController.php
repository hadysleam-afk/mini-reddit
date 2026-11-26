<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommunityController extends Controller
{
    /**
     * عرض جميع الـ Communities
     */
    public function index()
    {
        $communities = Community::with('owner')
            ->withCount('members')
            ->latest()
            ->paginate(12);

        return view(
            'communities.index',
            compact('communities')
        );
    }


    /**
     * صفحة إنشاء Community
     */
    public function create()
    {
        return view('communities.create');
    }


    /**
     * إنشاء Community جديدة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:communities,name',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
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
        | Generate unique slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($validated['name']);

        $originalSlug = $slug;

        $counter = 1;

        while (
            Community::where('slug', $slug)->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;

            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Upload image
        |--------------------------------------------------------------------------
        */

        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('communities', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Create community
        |--------------------------------------------------------------------------
        */

        $community = Community::create([

            'user_id' => auth()->id(),

            'name' => $validated['name'],

            'slug' => $slug,

            'description' =>
                $validated['description'] ?? null,

            'image' => $imagePath,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Owner becomes a member automatically
        |--------------------------------------------------------------------------
        */

        $community
            ->members()
            ->attach(auth()->id());


        return redirect()
            ->route(
                'communities.show',
                $community
            )
            ->with(
                'success',
                'Community created successfully.'
            );
    }


    /**
     * عرض Community معينة
     */
public function show(Community $community)
{
    $community->load('owner');

    $community->loadCount('members');

    $isMember = $community
        ->members()
        ->whereKey(auth()->id())
        ->exists();

    $posts = $community->posts()
        ->with('user')
        ->withCount([
            'likedBy',
            'comments'
        ])
        ->latest()
        ->paginate(10);

    return view(
        'communities.show',
        compact(
            'community',
            'isMember',
            'posts'
        )
    );
}


    /**
     * صفحة تعديل Community
     */
    public function edit(Community $community)
    {
        $this->authorize(
            'update',
            $community
        );

        return view(
            'communities.edit',
            compact('community')
        );
    }


    /**
     * تحديث Community
     */
    public function update(
        Request $request,
        Community $community
    ) {
        $this->authorize(
            'update',
            $community
        );


        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
                'unique:communities,name,' .
                $community->id,
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
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
        | Update image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            if ($community->image) {

                Storage::disk('public')
                    ->delete($community->image);
            }


            $community->image =
                $request
                    ->file('image')
                    ->store(
                        'communities',
                        'public'
                    );
        }


        $community->name =
            $validated['name'];

        $community->description =
            $validated['description'] ?? null;


        $community->save();


        return redirect()
            ->route(
                'communities.show',
                $community
            )
            ->with(
                'success',
                'Community updated successfully.'
            );
    }


    /**
     * حذف Community
     */
    public function destroy(
        Community $community
    ) {
        $this->authorize(
            'delete',
            $community
        );


        if ($community->image) {

            Storage::disk('public')
                ->delete($community->image);
        }


        $community->delete();


        return redirect()
            ->route('communities.index')
            ->with(
                'success',
                'Community deleted successfully.'
            );
    }


    /**
     * Join Community
     */
    public function join(
        Community $community
    ) {
        $alreadyMember = $community
            ->members()
            ->whereKey(auth()->id())
            ->exists();


        if (!$alreadyMember) {

            $community
                ->members()
                ->attach(auth()->id());
        }


        return back()
            ->with(
                'success',
                'You joined the community.'
            );
    }


    /**
     * Leave Community
     */
    public function leave(
        Community $community
    ) {
        /*
        |--------------------------------------------------------------------------
        | Owner cannot leave
        |--------------------------------------------------------------------------
        */

        if (
            $community->user_id ===
            auth()->id()
        ) {

            return back()
                ->with(
                    'error',
                    'The owner cannot leave the community.'
                );
        }


        $community
            ->members()
            ->detach(auth()->id());


        return back()
            ->with(
                'success',
                'You left the community.'
            );
    }
}
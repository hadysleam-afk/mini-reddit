<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'bio' => 'nullable|string|max:1000',

            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $user->name = $validated['name'];

        $user->bio = $validated['bio'] ?? null;


        if ($request->hasFile('avatar')) {

            if ($user->avatar) {
                Storage::disk('public')
                    ->delete($user->avatar);
            }

            $path = $request
                ->file('avatar')
                ->store('avatars', 'public');

            $user->avatar = $path;
        }


        $user->save();

        return redirect()
            ->route('profile.show')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }
}
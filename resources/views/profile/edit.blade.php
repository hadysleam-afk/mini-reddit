@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="card">

    <h1>
        Edit Profile
    </h1>


    <form
        action="{{ route('profile.update') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        @method('PUT')


        <label>
            Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $user->name) }}"
        >

        @error('name')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


        <label>
            Bio
        </label>

        <textarea
            name="bio"
            rows="5"
        >{{ old('bio', $user->bio) }}</textarea>

        @error('bio')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


        <label>
            Avatar
        </label>

        <input
            type="file"
            name="avatar"
            accept=".jpg,.jpeg,.png,.webp"
        >

        @error('avatar')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


        <button
            type="submit"
            class="btn"
        >
            Save Changes
        </button>

    </form>

</div>

@endsection
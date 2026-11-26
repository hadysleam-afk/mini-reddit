@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<div class="card">

    <h1>Create Post</h1>

    <form
        action="{{ route('posts.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf


        {{-- Title --}}
        <div>
            <label for="title">
                Title
            </label>

            <input
                id="title"
                type="text"
                name="title"
                value="{{ old('title') }}"
                required
            >

            @error('title')
                <div class="error">
                    {{ $message }}
                </div>
            @enderror
        </div>


        {{-- Content --}}
        <div>
            <label for="content">
                Content
            </label>

            <textarea
                id="content"
                name="content"
                rows="8"
                required
            >{{ old('content') }}</textarea>

            @error('content')
                <div class="error">
                    {{ $message }}
                </div>
            @enderror
        </div>


        {{-- Community --}}
        <div>

            <label for="community_id">
                Community
            </label>

            <select
                id="community_id"
                name="community_id"
            >

                {{-- Profile Post --}}
                <option value="">
                    My Profile
                </option>


                {{-- Communities --}}
                @foreach($communities as $community)

                    <option
                        value="{{ $community->id }}"

                        @selected(
                            old(
                                'community_id',
                                $selectedCommunity?->id
                            ) == $community->id
                        )
                    >

                        {{ $community->name }}

                    </option>

                @endforeach

            </select>


            @error('community_id')

                <div class="error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Image --}}
        <div>

            <label for="image">
                Image
            </label>

            <input
                id="image"
                type="file"
                name="image"
                accept=".jpg,.jpeg,.png,.webp"
            >

            @error('image')

                <div class="error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Submit --}}
        <button
            type="submit"
            class="btn"
        >
            Create Post
        </button>

    </form>

</div>

@endsection
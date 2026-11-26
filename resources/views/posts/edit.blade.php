@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

<div class="card">

```
<h1>
    Edit Post
</h1>


<form
    action="{{ route(
        'posts.update',
        $post
    ) }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    @method('PUT')


    <label>
        Title
    </label>

    <input
        type="text"
        name="title"
        value="{{ old(
            'title',
            $post->title
        ) }}"
    >


    @error('title')

        <div class="error">
            {{ $message }}
        </div>

    @enderror


    <br><br>


    <label>
        Content
    </label>

    <textarea
        name="content"
        rows="10"
    >{{ old(
        'content',
        $post->content
    ) }}</textarea>


    @error('content')

        <div class="error">
            {{ $message }}
        </div>

    @enderror


    <br><br>


    <label>
        Community
    </label>

    <select name="community_id">

        <option value="">
            My Profile
        </option>


        @foreach($communities as $community)

            <option
                value="{{ $community->id }}"
                @selected(
                    old(
                        'community_id',
                        $post->community_id
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


    <br><br>


    @if($post->image)

        <p>
            Current Image:
        </p>


        <img
            src="{{ asset(
                'storage/' . $post->image
            ) }}"
            alt="{{ $post->title }}"
            width="200"
            style="
                border-radius:10px;
            "
        >

        <br><br>

    @endif


    <label>
        New Image
    </label>

    <input
        type="file"
        name="image"
        accept=".jpg,.jpeg,.png,.webp"
    >


    @error('image')

        <div class="error">
            {{ $message }}
        </div>

    @enderror


    <br><br>


    <button
        type="submit"
        class="btn"
    >
        Save Changes
    </button>

</form>
```

</div>

@endsection

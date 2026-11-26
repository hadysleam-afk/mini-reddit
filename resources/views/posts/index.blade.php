@extends('layouts.app')

@section('title', 'Posts')

@section('content')

<div class="card">

```
<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
">

    <h1>Posts</h1>

    <a
        href="{{ route('posts.create') }}"
        class="btn"
    >
        Create Post
    </a>

</div>


@if(session('success'))

    <div class="success">
        {{ session('success') }}
    </div>

@endif


<hr>


@forelse($posts as $post)

    <div style="
        border:1px solid #ddd;
        padding:20px;
        margin-bottom:20px;
        border-radius:10px;
    ">

        <h2>

            <a
                href="{{ route('posts.show', $post) }}"
            >
                {{ $post->title }}
            </a>

        </h2>


        <p>

            By:

            <a href="{{ route('users.show', $post->user) }}">
                {{ $post->user->name }}
            </a>

        </p>


        @if($post->community)

            <p>

                Community:

                <a
                    href="{{ route(
                        'communities.show',
                        $post->community
                    ) }}"
                >
                    {{ $post->community->name }}
                </a>

            </p>

        @else

            <p>
                Profile Post
            </p>

        @endif


        @if($post->image)

            <img
                src="{{ asset(
                    'storage/' . $post->image
                ) }}"
                alt="{{ $post->title }}"
                style="
                    max-width:100%;
                    max-height:400px;
                    border-radius:10px;
                "
            >

        @endif


        <p>
            {{ Str::limit($post->content, 200) }}
        </p>


        <p>

            ❤️ {{ $post->liked_by_count }}

            &nbsp;&nbsp;

            💬 {{ $post->comments_count }}

        </p>

    </div>

@empty

    <p>
        No posts found.
    </p>

@endforelse


{{ $posts->links() }}
```

</div>

@endsection

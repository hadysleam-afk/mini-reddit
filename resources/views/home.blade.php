@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="card">

    <h1>
        Home Feed
    </h1>

    <p>
        Posts from your communities and your profile.
    </p>

    <a
        href="{{ route('posts.create') }}"
        class="btn"
    >
        Create Post
    </a>

</div>


@forelse($posts as $post)

    <div class="card">

        {{-- Author --}}
        <p>

            <strong>

                <a
                    href="{{ route('users.show', $post->user) }}"
                >
                    {{ $post->user->name }}
                </a>

            </strong>


            @if($post->community)

                <span>
                    in
                </span>

                <a
                    href="{{ route(
                        'communities.show',
                        $post->community
                    ) }}"
                >
                    {{ $post->community->name }}
                </a>

            @else

                <span>
                    on profile
                </span>

            @endif

        </p>


        {{-- Title --}}
        <h2>

            <a
                href="{{ route('posts.show', $post) }}"
            >
                {{ $post->title }}
            </a>

        </h2>


        {{-- Content --}}
        <p>
            {{ Str::limit($post->content, 300) }}
        </p>


        {{-- Image --}}
        @if($post->image)

            <img
                src="{{ asset(
                    'storage/' . $post->image
                ) }}"
                alt="Post image"
                style="
                    max-width: 400px;
                    width: 100%;
                    height: auto;
                "
            >

        @endif


        {{-- Statistics --}}
        <p>

            ❤️ {{ $post->liked_by_count }}

            &nbsp;&nbsp;

            💬 {{ $post->comments_count }}

        </p>

    </div>

@empty

    <div class="card">

        <h2>
            Your feed is empty
        </h2>

        <p>
            Join some communities or create your first post.
        </p>

        <a
            href="{{ route('communities.index') }}"
            class="btn"
        >
            Explore Communities
        </a>

    </div>

@endforelse


{{ $posts->links() }}

@endsection
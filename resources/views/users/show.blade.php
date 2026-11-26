@extends('layouts.app')

@section('title', $user->name . ' Profile')

@section('content')

<div class="card">

    {{-- Avatar --}}
    @if($user->avatar)
        <img
            src="{{ asset('storage/' . $user->avatar) }}"
            alt="Avatar"
            width="120"
            height="120"
            style="border-radius: 50%; object-fit: cover;"
        >
    @else
        <div>
            No Avatar
        </div>
    @endif

    {{-- User name --}}
    <h1>
        {{ $user->name }}
    </h1>

    {{-- Bio --}}
    <p>
        {{ $user->bio ?? 'No bio yet.' }}
    </p>

    {{-- Email --}}
    <p>
        {{ $user->email }}
    </p>

</div>


<h2>Posts</h2>

@forelse($posts as $post)

    <div class="card">

        <h2>
            <a href="{{ route('posts.show', $post) }}">
                {{ $post->title }}
            </a>
        </h2>

        <p>
            {{ Str::limit($post->content, 200) }}
        </p>

        @if($post->community)
            <p>
                Community:
                <a href="{{ route('communities.show', $post->community) }}">
                    {{ $post->community->name }}
                </a>
            </p>
        @endif

        <p>
            ❤️ {{ $post->liked_by_count }}
            💬 {{ $post->comments_count }}
        </p>

    </div>

@empty

    <p>
        This user has no posts yet.
    </p>

@endforelse


{{ $posts->links() }}

@endsection
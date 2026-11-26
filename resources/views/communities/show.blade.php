@extends('layouts.app')

@section('title', $community->name)

@section('content')

<div class="card">

    {{-- Community Image --}}
    @if($community->image)

        <img
            src="{{ asset('storage/' . $community->image) }}"
            alt="{{ $community->name }}"
            style="
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 15px;
            "
        >

    @endif


    {{-- Community Name --}}
    <h1>
        {{ $community->name }}
    </h1>


    {{-- Description --}}
    <p>
        {{ $community->description ?? 'No description.' }}
    </p>


    {{-- Owner --}}
    <p>
        Owner:

        <a href="{{ route('users.show', $community->owner) }}">
            {{ $community->owner->name }}
        </a>
    </p>


    {{-- Members --}}
    <p>
        Members:
        {{ $community->members_count }}
    </p>


    {{-- Join / Leave --}}
    @if($isMember)

        <form
            action="{{ route('communities.leave', $community) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')

            <button type="submit">
                Leave Community
            </button>
        </form>

    @else

        <form
            action="{{ route('communities.join', $community) }}"
            method="POST"
        >
            @csrf

            <button type="submit">
                Join Community
            </button>
        </form>

    @endif


    {{-- Owner Controls --}}
    @can('update', $community)

        <br>

        <a href="{{ route('communities.edit', $community) }}">
            Edit Community
        </a>

    @endcan


    @can('delete', $community)

        <form
            action="{{ route('communities.destroy', $community) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')

            <button type="submit">
                Delete Community
            </button>
        </form>

    @endcan

</div>


{{-- ================================= --}}
{{-- Community Posts --}}
{{-- ================================= --}}

<div class="card">

    <h2>
        Community Posts
    </h2>


    {{-- Create Post --}}
    @if($isMember)

        <a
            href="{{ route('posts.create', ['community' => $community->id]) }}"
            class="btn"
        >
            Create Post in {{ $community->name }}
        </a>

    @else

        <p>
            Join this community to create posts.
        </p>

    @endif

</div>


{{-- Posts --}}
@forelse($posts as $post)

    <div class="card">

        {{-- Author --}}
        <p>

            <strong>
                <a href="{{ route('users.show', $post->user) }}">
                    {{ $post->user->name }}
                </a>
            </strong>

        </p>


        {{-- Post Title --}}
        <h2>

            <a href="{{ route('posts.show', $post) }}">
                {{ $post->title }}
            </a>

        </h2>


        {{-- Post Content --}}
        <p>
            {{ \Illuminate\Support\Str::limit($post->content, 300) }}
        </p>


        {{-- Post Image --}}
        @if($post->image)

            <img
                src="{{ asset('storage/' . $post->image) }}"
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

            ❤️
            {{ $post->liked_by_count }}

            &nbsp;&nbsp;

            💬
            {{ $post->comments_count }}

        </p>

    </div>

@empty

    <div class="card">

        <p>
            No posts in this community yet.
        </p>

        @if($isMember)

            <a href="{{ route('posts.create', ['community' => $community->id]) }}">
                Create the first post
            </a>

        @endif

    </div>

@endforelse


{{-- Pagination --}}
{{ $posts->links() }}

@endsection
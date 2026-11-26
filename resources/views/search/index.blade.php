@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', 'Search')

@section('content')

<h1>Search</h1>


<form
    action="{{ route('search') }}"
    method="GET"
>

    <input
        type="search"
        name="q"
        value="{{ $query }}"
        placeholder="Search..."
    >

    <button type="submit">
        Search
    </button>

</form>


@if($query !== '')

    <hr>

    <h2>
        Search results for:
        "{{ $query }}"
    </h2>


    {{-- Users --}}
    <h2>Users</h2>

    @forelse($users as $user)

        <div class="card">

            <a href="{{ route('users.show', $user) }}">
                {{ $user->name }}
            </a>

        </div>

    @empty

        <p>
            No users found.
        </p>

    @endforelse


    {{-- Communities --}}
    <h2>Communities</h2>

    @forelse($communities as $community)

        <div class="card">

            <a href="{{ route('communities.show', $community) }}">
                {{ $community->name }}
            </a>

            <p>
                {{ $community->description }}
            </p>

        </div>

    @empty

        <p>
            No communities found.
        </p>

    @endforelse


    {{-- Posts --}}
    <h2>Posts</h2>

    @forelse($posts as $post)

        <div class="card">

            <h3>

                <a href="{{ route('posts.show', $post) }}">
                    {{ $post->title }}
                </a>

            </h3>

            <p>
                {{ Str::limit($post->content, 200) }}
            </p>

            <small>
                By
                <a href="{{ route('users.show', $post->user) }}">
                    {{ $post->user->name }}
                </a>
            </small>

        </div>

    @empty

        <p>
            No posts found.
        </p>

    @endforelse

@endif

@endsection
@extends('layouts.app')

@section('title', $post->title)

@section('content')

<div class="card">

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <h1>{{ $post->title }}</h1>

    <p>By: <strong>
        <a href="{{ route('users.show', $post->user) }}">
            {{ $post->user->name }}
        </a>
    </strong></p>

    @if($post->community)
        <p>Community: <a href="{{ route('communities.show', $post->community) }}">{{ $post->community->name }}</a></p>
    @else
        <p>Profile Post</p>
    @endif

    <hr>

    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width:100%; max-height:600px; border-radius:10px;">
        <br><br>
    @endif

    <div>{{ $post->content }}</div>

    <hr>

    <p>❤️ Likes: {{ $post->liked_by_count }} &nbsp;&nbsp; 💬 Comments: {{ $post->comments_count }}</p>
    @if($isLiked)

```
<form
    action="{{ route(
        'posts.unlike',
        $post
    ) }}"
    method="POST"
    style="display:inline;"
>

    @csrf

    @method('DELETE')


    <button
        type="submit"
        class="btn"
    >
        ❤️ Unlike
    </button>

</form>
```

@else

```
<form
    action="{{ route(
        'posts.like',
        $post
    ) }}"
    method="POST"
    style="display:inline;"
>

    @csrf


    <button
        type="submit"
        class="btn"
    >
        🤍 Like
    </button>

</form>
```

@endif

    @if($post->user_id === auth()->id())
        <hr>
        <a href="{{ route('posts.edit', $post) }}" class="btn">Edit</a>
        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" onclick="return confirm('Delete this post?')">Delete</button>
        </form>
    @endif

    <hr>

    <h2>Comments</h2>

    {{-- Add Comment --}}
    <form action="{{ route('comments.store', $post) }}" method="POST">
        @csrf
        <textarea name="content" rows="5" placeholder="Write a comment...">{{ old('content') }}</textarea>
        @error('content')
            <div class="error">{{ $message }}</div>
        @enderror
        <br>
        <button type="submit" class="btn">Add Comment</button>
    </form>

    <hr>

    {{-- Comments List --}}
    @forelse($post->comments()->latest()->get() as $comment)
        <div style="border:1px solid #ddd; padding:15px; margin-bottom:15px; border-radius:10px;">
            <strong>{{ $comment->user->name }}</strong>
            <small>{{ $comment->created_at->diffForHumans() }}</small>
            <p>{{ $comment->content }}</p>

            @if($comment->user_id === auth()->id())
                <a href="{{ route('comments.edit', $comment) }}">Edit</a>
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this comment?')">Delete</button>
                </form>
            @endif
        </div>
    @empty
        <p>No comments yet.</p>
    @endforelse

</div>

@endsection
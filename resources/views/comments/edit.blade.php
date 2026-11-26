@extends('layouts.app')

@section('title', 'Edit Comment')

@section('content')

<div class="card">

```
<h1>
    Edit Comment
</h1>


<form
    action="{{ route(
        'comments.update',
        $comment
    ) }}"
    method="POST"
>

    @csrf

    @method('PUT')


    <textarea
        name="content"
        rows="8"
    >{{ old(
        'content',
        $comment->content
    ) }}</textarea>


    @error('content')

        <div class="error">
            {{ $message }}
        </div>

    @enderror


    <br><br>


    <button
        type="submit"
        class="btn"
    >
        Update Comment
    </button>

</form>
```

</div>

@endsection

@extends('layouts.app')

@section('title', 'Create Community')

@section('content')

<div class="card">

```
<h1>Create Community</h1>


<form
    action="{{ route('communities.store') }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf


    <label>
        Community Name
    </label>

    <input
        type="text"
        name="name"
        value="{{ old('name') }}"
        placeholder="Example: Laravel Developers"
    >

    @error('name')
        <div class="error">
            {{ $message }}
        </div>
    @enderror


    <br><br>


    <label>
        Description
    </label>

    <textarea
        name="description"
        rows="6"
        placeholder="Describe your community..."
    >{{ old('description') }}</textarea>

    @error('description')
        <div class="error">
            {{ $message }}
        </div>
    @enderror


    <br><br>


    <label>
        Community Image
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
        Create Community
    </button>

</form>
```

</div>

@endsection

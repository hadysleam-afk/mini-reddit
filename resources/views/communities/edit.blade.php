@extends('layouts.app')

@section('title', 'Edit Community')

@section('content')

<div class="card">

```
<h1>
    Edit Community
</h1>


<form
    action="{{ route('communities.update', $community) }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    @method('PUT')


    <label>
        Community Name
    </label>

    <input
        type="text"
        name="name"
        value="{{ old('name', $community->name) }}"
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
    >{{ old('description', $community->description) }}</textarea>

    @error('description')
        <div class="error">
            {{ $message }}
        </div>
    @enderror


    <br><br>


    @if($community->image)

        <p>
            Current Image:
        </p>

        <img
            src="{{ asset('storage/' . $community->image) }}"
            alt="{{ $community->name }}"
            width="150"
            height="150"
            style="
                object-fit:cover;
                border-radius:15px;
            "
        >

    @endif


    <br><br>


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

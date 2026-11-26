@extends('layouts.app')

@section('title', 'Communities')

@section('content')

<div class="card">

```
<div style="display:flex; justify-content:space-between; align-items:center;">

    <h1>Communities</h1>

    <a
        href="{{ route('communities.create') }}"
        class="btn"
    >
        Create Community
    </a>

</div>


@if(session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif


@if(session('error'))
    <div class="error">
        {{ session('error') }}
    </div>
@endif


<hr>


@forelse($communities as $community)

    <div
        style="
            border:1px solid #ddd;
            padding:20px;
            margin-bottom:15px;
            border-radius:10px;
        "
    >

        @if($community->image)

            <img
                src="{{ asset('storage/' . $community->image) }}"
                alt="{{ $community->name }}"
                width="100"
                height="100"
                style="
                    object-fit:cover;
                    border-radius:10px;
                "
            >

        @endif


        <h2>

            <a
                href="{{ route('communities.show', $community) }}"
            >
                {{ $community->name }}
            </a>

        </h2>


        <p>
            {{ $community->description ?? 'No description.' }}
        </p>


        <p>
            Owner:
            {{ $community->owner->name }}
        </p>


        <p>
            Members:
            {{ $community->members_count }}
        </p>

    </div>

@empty

    <p>
        No communities found.
    </p>

@endforelse


{{ $communities->links() }}
```

</div>

@endsection

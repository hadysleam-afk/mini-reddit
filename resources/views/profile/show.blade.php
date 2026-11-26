@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="card">

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


    <h1>
        {{ $user->name }}
    </h1>


    <p>
        {{ $user->bio ?? 'No bio yet.' }}
    </p>


    <a href="{{ route('profile.edit') }}">
        Edit Profile
    </a>

</div>

@endsection
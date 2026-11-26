@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="card">

    <h1>Login</h1>

    <form
        action="{{ route('login') }}"
        method="POST"
    >

        @csrf

        <label>
            Email
        </label>

        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
        >

        @error('email')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


        <label>
            Password
        </label>

        <input
            type="password"
            name="password"
        >

        @error('password')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


        <button
            type="submit"
            class="btn"
        >
            Login
        </button>

    </form>

</div>

@endsection
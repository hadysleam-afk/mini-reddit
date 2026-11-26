@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="card">

    <h1>Create Account</h1>

    <form
        action="{{ route('register') }}"
        method="POST"
    >

        @csrf

        <label>
            Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
        >

        @error('name')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


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


        <label>
            Confirm Password
        </label>

        <input
            type="password"
            name="password_confirmation"
        >


        <button
            type="submit"
            class="btn"
        >
            Register
        </button>

    </form>

</div>

@endsection
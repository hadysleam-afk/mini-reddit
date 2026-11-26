<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Mini Reddit')
    </title>

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >

</head>
<body>

    <!-- ================= NAVBAR ================= -->

    <nav class="navbar">

        <div class="navbar-container">

            <!-- Logo -->

            <a
                href="{{ auth()->check() ? route('home') : route('login') }}"
                class="logo"
            >
                🔴 MiniReddit
            </a>


            <!-- Mobile Menu Button -->

            <button
                class="mobile-menu-button"
                id="mobileMenuButton"
                type="button"
            >
                ☰
            </button>


            <!-- Navigation -->

            <div
                class="nav-menu"
                id="navMenu"
            >

                @auth

                    <!-- Search -->

                    <form
                        action="{{ route('search') }}"
                        method="GET"
                        class="search-form"
                    >

                        <input
                            type="search"
                            name="q"
                            placeholder="Search..."
                            value="{{ request('q') }}"
                        >

                        <button type="submit">
                            🔍
                        </button>

                    </form>


                    <!-- Links -->

                    <div class="nav-links">

                        <a href="{{ route('home') }}">
                            🏠 Home
                        </a>

                        <a href="{{ route('posts.index') }}">
                            📝 Posts
                        </a>

                        <a href="{{ route('communities.index') }}">
                            👥 Communities
                        </a>

                        <a href="{{ route('profile.show') }}">
                            👤 Profile
                        </a>


                        <!-- Logout -->

                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                            class="logout-form"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="nav-logout"
                            >
                                Logout
                            </button>

                        </form>

                    </div>

                @else

                    <div class="nav-links">

                        <a href="{{ route('login') }}">
                            Login
                        </a>

                        <a
                            href="{{ route('register') }}"
                            class="nav-register"
                        >
                            Register
                        </a>

                    </div>

                @endauth

            </div>

        </div>

    </nav>


    <!-- ================= MAIN ================= -->

    <main class="main-container">


        <!-- Success Message -->

        @if(session('success'))

            <div class="alert alert-success">

                <span>
                    ✓
                </span>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        <!-- Error Message -->

        @if(session('error'))

            <div class="alert alert-error">

                <span>
                    ✕
                </span>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif


        <!-- Validation Errors -->

        @if($errors->any())

            <div class="alert alert-error">

                <div>

                    <strong>
                        Please fix the following errors:
                    </strong>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        <!-- Page Content -->

        @yield('content')


    </main>


    <!-- ================= FOOTER ================= -->

    <footer class="footer">

        <div class="footer-container">

            <p>
                © {{ date('Y') }} MiniReddit
            </p>

            <p>
                Built with Laravel ❤️
            </p>

        </div>

    </footer>


    <!-- JavaScript -->

<script src="{{ asset('js/app.js') }}"></script>

@stack('scripts')

</body>
</html>
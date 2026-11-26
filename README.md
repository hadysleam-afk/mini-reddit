# Mini Reddit

A Reddit-style community platform built with Laravel. Users can create and join communities, publish posts with optional images, comment, like posts, manage their profiles, and search across the platform.

## Features

- **Authentication**: registration, login, and logout with hashed passwords and session protection
- **Communities**: create, edit, browse, join, and leave communities
- **Posts**: full CRUD with optional image uploads and optional community association (membership required to post in a community)
- **Comments**: add, edit, and delete comments on posts
- **Likes**: like and unlike posts
- **Profiles**: view and edit your own profile, view other users' profiles
- **Search**: search across posts and communities
- **Authorization**: policy-based permissions so users only modify their own content
- **API**: Laravel Sanctum installed; a connection-test route is the only API endpoint so far

## Tech Stack

- [Laravel 12](https://laravel.com) (PHP 8.2+)
- Blade templates with a hand-crafted custom CSS frontend (static assets in `public/`)
- SQLite by default (other database drivers are configurable but not verified)
- Laravel Sanctum installed as a dependency

### Frontend tooling note

The repository keeps the Vite/Tailwind/React scaffolding (`vite.config.js`, `package.json`) for potential future use. Its entry points (`resources/css/app.css`, `resources/js/app.js`) do not exist yet, so `npm run build` is intentionally not part of the setup steps. The current UI runs entirely on the static `public/css/app.css` and `public/js/app.js`.

## Requirements

- PHP 8.2 or higher
- Composer

## Installation

```bash
git clone https://github.com/hadysleam-afk/mini-reddit.git
cd mini-reddit

composer install
cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate
php artisan storage:link

php artisan serve
```

Then open http://localhost:8000 and register an account.

Or run the setup steps in one command, then start the server:

```bash
composer run setup
php artisan serve
```

## Usage

1. **Register** a new account from the registration page.
2. **Create a community** (or join an existing one) from the Communities page.
3. **Create a post** inside a community, with an optional image.
4. **Comment and like** on posts, and use the search page to find content.

## Project Structure

```
app/
├── Http/Controllers/   # Auth, Home, Community, Post, Comment, Like, Profile, Search, User
├── Models/             # User, Community, Post, Comment
└── Policies/           # Community, Post, Comment authorization
database/
├── factories/
├── migrations/         # users, communities, posts, comments, likes, memberships
└── seeders/
public/
├── css/app.css         # custom hand-written styles
└── js/app.js           # navbar and UI interactions
resources/views/        # Blade templates (auth, communities, posts, comments, profile, search)
routes/
├── web.php             # web routes
└── api.php             # connection-test route
tests/                  # PHPUnit scaffold (feature + unit)
```

## Testing

```bash
php artisan test
```

The test suite currently contains the default Laravel scaffold tests.

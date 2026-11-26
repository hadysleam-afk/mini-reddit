<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
Route::get('/', function () {
    return redirect()->route('home');
});


// ==========================
// Authentication
// ==========================

Route::get('/register', [
    AuthController::class,
    'showRegister'
])->name('register');

Route::post('/register', [
    AuthController::class,
    'register'
]);

Route::get('/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
]);

Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');


// ==========================
// Protected Routes
// ==========================

Route::middleware('auth')->group(function () {

    Route::get('/home', [
        HomeController::class,
       'index'
    ])->name('home');

    Route::get('/search', [
    SearchController::class,
    'index'
    ])->name('search');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [
    ProfileController::class,
    'show'
])->name('profile.show');


Route::get('/profile/edit', [
    ProfileController::class,
    'edit'
])->name('profile.edit');


Route::put('/profile', [
    ProfileController::class,
    'update'
])->name('profile.update');

});



Route::middleware('auth')->group(function () {

/*
|--------------------------------------------------------------------------
| Communities
|--------------------------------------------------------------------------
*/

Route::resource(
    'communities',
    CommunityController::class
);

Route::post(
    '/communities/{community}/join',
    [
        CommunityController::class,
        'join'
    ]
)->name('communities.join');

Route::delete(
    '/communities/{community}/leave',
    [
        CommunityController::class,
        'leave'
    ]
)->name('communities.leave');

});

Route::middleware('auth')->group(function () {

/*
|--------------------------------------------------------------------------
| Posts
|--------------------------------------------------------------------------
*/

Route::resource(
    'posts',
    PostController::class
);
});




Route::middleware('auth')->group(function () {


/*
|--------------------------------------------------------------------------
| Comments
|--------------------------------------------------------------------------
*/

Route::post(
    '/posts/{post}/comments',
    [
        CommentController::class,
        'store'
    ]
)->name('comments.store');


Route::get(
    '/comments/{comment}/edit',
    [
        CommentController::class,
        'edit'
    ]
)->name('comments.edit');


Route::put(
    '/comments/{comment}',
    [
        CommentController::class,
        'update'
    ]
)->name('comments.update');


Route::delete(
    '/comments/{comment}',
    [
        CommentController::class,
        'destroy'
    ]
)->name('comments.destroy');
});




/*
|--------------------------------------------------------------------------
| Likes
|--------------------------------------------------------------------------
*/

Route::post(
    '/posts/{post}/like',
    [
        LikeController::class,
        'store'
    ]
)->name('posts.like');


Route::delete(
    '/posts/{post}/like',
    [
        LikeController::class,
        'destroy'
    ]
)->name('posts.unlike');



Route::middleware('auth')->group(function () {

Route::get('/users/{user}', [
    UserController::class,
    'show'
])->name('users.show');

});


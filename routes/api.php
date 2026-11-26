<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-connection', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'أهلاً بك! الاتصال بين React و Laravel يعمل بنجاح 🎉'
    ]);
});
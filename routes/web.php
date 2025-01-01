<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('dashboard')->group(function () {
    Route::resource('/category', CategoryController::class);
    Route::resource('/post', PostController::class);
    Route::post('/post/upload/{post}', [PostController::class, 'upload'])->name('post.upload');
    Route::delete('/post/image/delete/{post}', [PostController::class, 'imageDelete'])->name('post.image.delete');
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Route::inertia('indexinertia', 'Dashboard/Post/Index');


<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Contact\GeneralController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\PersonController;
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

Route::group([
    'prefix' => 'contact',
    // 'middleware' => [
    //     'auth:sanctum',
    //     config('jetstream.auth_session'),
    //     'verified'
    // ]
], function () {
    Route::resource('contact-general', GeneralController::class)->only([
        'create',
        'edit',
        'store',
        'update'
    ]);
    Route::resource('contact-company', CompanyController::class)->only([
        'create',
        'edit',
        'store',
        'update'
    ]);
    Route::resource('contact-person', PersonController::class)->only([
        'create',
        'edit',
        'store',
        'update'
    ]);
    Route::resource('contact-detail', DetailController::class)->only([
        'create',
        'edit',
        'store',
        'update'
    ]);
});

// Route::inertia('indexinertia', 'Dashboard/Post/Index');

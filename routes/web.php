<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');

Route::get('/create', [PostController::class, 'create'])
    ->name('posts.create');

Route::post('/store', [PostController::class, 'store'])
    ->name('posts.store');

Route::get('/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::get('/{post}/edit', [PostController::class, 'edit'])
    ->name('posts.edit');

Route::patch('/{post}', [PostController::class, 'update'])
    ->name('posts.update');

Route::delete('/{post}', [PostController::class, 'destroy'])
    ->name('posts.destroy');
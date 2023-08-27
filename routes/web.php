<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    Route::get('/admin', 'admin')->name('admin');
    Route::get('/admin/posts', 'adminposts')->name('adminposts');
    Route::get('/', 'index')->name('index');
    Route::get('/myposts', 'myposts')->name('myposts');
    Route::post('/posts', 'store')->name('store');
    Route::get('/posts/create', 'create')->name('create');
    Route::get('/posts/{post}', 'show')->name('show');
    Route::get('/myposts/{post}/edit', 'edit')->name('edit');
    Route::put('/myposts/{post}', 'update')->name('update');
    Route::delete('/myposts/{post}', 'delete')->name('delete');
    Route::delete('/admin/posts/{post}', 'delete')->name('delete');
});

Route::controller(App\Http\Controllers\ChatController::class)->middleware(['auth'])->group(function(){
    Route::get('/posts/chats/{post}', 'chat')->name('chat');
    Route::post('/posts/chats/{post}', 'sendMessage')->name('sendMessage');
    // Route::post('/chat', [App\Http\Controllers\ChatController::class, 'sendMessage']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/posts/chats/{post}', [App\Http\Controllers\ChatController::class, 'chat']);

require __DIR__.'/auth.php';





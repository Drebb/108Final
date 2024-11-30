<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
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


Route::middleware(['auth', 'setDB'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render(
            'Dashboard'
        );
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/blogs/recent', [BlogController::class, 'recent'])->name('blogs.recent');
    Route::get('/blogs/random', [BlogController::class, 'random'])->name('blogs.random');
    Route::resource('blogs', BlogController::class);

    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/refresh-statistics', [AdminController::class, 'refreshStatistics'])->name('refresh-statistics');
        Route::get('/user-functions', [AdminController::class, 'userFunctions'])->name('user-functions');
        Route::get('/get-user-blog-count', [AdminController::class, 'getUserBlogCount'])->name('get-user-blog-count');
        Route::get('/get-recent-user-blogs', [AdminController::class, 'getRecentUserBlogs'])->name('get-recent-user-blogs');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('update-user');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('delete-user');
    });
});
require __DIR__ . '/auth.php';

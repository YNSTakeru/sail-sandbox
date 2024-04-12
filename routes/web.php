<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ArticleController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/articles/{id}', 'show')->name('articles.show');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('editor')->middleware(['auth'])->controller(ArticleController::class)->name("articles.")->group(function () {
    Route::get("/", "create")->name("create");
    Route::post("/", "store")->name("store");
});


require __DIR__.'/auth.php';

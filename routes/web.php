<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ArticleController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'index')->name('home.post');
    Route::get('/articles/{id}', 'show')->name('articles.show');
});



Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile/{id}', 'index')->name('profile');
    Route::middleware(['auth'])->get('/settings', 'show')->name('settings');
    Route::get("profile/{id}/favorite", "favoriteIndex")->name("profile.favorite");
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::prefix('editor')->middleware(['auth'])->controller(ArticleController::class)->name("articles.")->group(function () {
    Route::get("/", "create")->name("create");
    Route::post("/", "store")->name("store");
    Route::get("{id}/edit", "edit")->name("edit");
    Route::put("{id}", "update")->name("update");
    Route::delete("/{id}/destroy", "destroy")->name("destroy");
});

Route::middleware(['auth'])->controller(CommentController::class)->group(function () {
    Route::post('/articles/{id}', 'store')->name('comments.store');
});

Route::middleware(['auth'])->controller(ArticleController::class)->name("articles.")->group(function () {
    Route::post("/articles/{id}/favorite/{user_id}", "updateFavorite")->name("favorite");
});

require __DIR__.'/auth.php';

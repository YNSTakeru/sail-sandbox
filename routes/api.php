<?php

use App\Http\Controllers\ApiArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/", [ApiArticleController::class, "index"])->name("home");

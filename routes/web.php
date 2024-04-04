<?php

use App\Http\Controllers\ArticleController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;


Route::get("/", [ArticleController::class, "index"]);

Route::get("/create/edit-article", function() {
    return view("create.edit-article");
});

Route::get("/article", function() {
    return view("article");
});


// Route::fallback(
//     function () {
//         return redirect("/#");
//     }
// );

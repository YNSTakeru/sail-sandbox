<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get("/create/edit-article", function() {
    return view("create-edit-article");
});

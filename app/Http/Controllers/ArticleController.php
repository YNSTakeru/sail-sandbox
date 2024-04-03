<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index()
    {
        $users = User::all();

        // bladeファイルの名前を指定して、compactで変数を渡す
        return view("home", compact("users"));

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index()
    {
        $users = User::all();
        $articles = Article::select("articles.*", "users.name as user_name")
            ->join("users", "articles.user_id", "=", "users.id")->orderBy("articles.created_at", "desc")
            ->paginate(10);

        $tags = Tag::all();
        $articleTags = ArticleTag::all();

        $favoriteTags = DB::table("article_tags")->join("articles", "article_tags.article_id", "=", "articles.id")->join("tags", "article_tags.tag_id", "=", "tags.name")
            ->select(DB::raw("SUM(articles.favorite_count) as total_favorite_count"),"tags.name as tag_name")->groupBy("tags.name")->orderBy("total_favorite_count", "desc")->limit(10)
            ->get();


        // bladeファイルの名前を指定して、compactで変数を渡す
        return view("home", compact("articles", "users", "tags", "articleTags", "favoriteTags"));

    }
}

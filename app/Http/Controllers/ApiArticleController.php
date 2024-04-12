<?php

namespace App\Http\Controllers;

use App\Models\ApiArticle;
use App\Models\Article;
use Illuminate\Http\Request;

class ApiArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tag = $request->input("tag");
        // Articleの記事をtagでフィルタリングする
        if ($tag) {
            $articles = Article::select("articles.*", "users.name as user_name", "article_tags.tag_id as tag_name")->join("users", "articles.user_id", "=", "users.id")->join("article_tags", "articles.id", "=", "article_tags.article_id")->where("article_tags.tag_id", $tag)->orderBy("articles.created_at", "desc")->paginate(10);
        } else {
            $articles = Article::all();
        }

        return response()->json($articles, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ApiArticle $apiArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApiArticle $apiArticle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApiArticle $apiArticle)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserFavoriteArticles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $requestTag = $request->input('tag');

        // ここからtagがある時ない時でフィルタリング

        $users = User::all();

        if(!$requestTag) {
            $articles = Article::select("articles.*", "users.name as user_name")
            ->join("users", "articles.user_id", "=", "users.id")->orderBy("articles.created_at", "desc")
            ->paginate(10);
        }

        if($requestTag) {
            $articles = Article::select("articles.*", "users.name as user_name", "article_tags.tag_id as tag_name")->join("users", "articles.user_id", "=", "users.id")->join("article_tags", "articles.id", "=", "article_tags.article_id")->where("article_tags.tag_id", $requestTag)->orderBy("articles.created_at", "desc")->paginate(10)->appends(["tag" => $requestTag]);
        }


        $tags = Tag::all();
        $articleTags = ArticleTag::all();

        $favoriteTags = DB::table("article_tags")->join("articles", "article_tags.article_id", "=", "articles.id")->join("tags", "article_tags.tag_id", "=", "tags.name")
        ->select(DB::raw("SUM(articles.favorite_count) as total_favorite_count"), "tags.name as tag_name")->groupBy("tags.name")->orderBy("total_favorite_count", "desc")->limit(10)
        ->get();

        // bladeファイルの名前を指定して、compactで変数を渡す
        return view("home", compact("articles", "users", "tags", "articleTags", "favoriteTags"));

    }

    public function create()
    {
        return view("articles.create");
    }

    public function store(StoreArticleRequest $request)
    {
        if(auth()->guest()) {
            return response()->json(["error" => "Unauthorized"], 401);
        }

        $tags = $request->tags;
        $tagModels = [];
        foreach ($tags as $tag) {
            $tagModel = Tag::firstOrCreate(["name" => $tag]);
            $tagModels[] = $tagModel;
        }

        $article = Article::create([
            "title" => $request->title,
            "abstract" => $request->abstract,
            "content" => $request->content,
            "user_id" => $request->user_id,
            "favorite_count" => 0,
        ]);

        // ArticleTagモデルを作成
        foreach ($tagModels as $tagModel) {
            ArticleTag::create([
                "article_id" => $article->id,
                "tag_id" => $tagModel->name,
            ]);
        }


        return to_route("home");
    }

    public function show($id)
    {
        $article = Article::find($id);
        $user = User::find($article->user_id);
        $tags = Tag::all();
        $articleTags = ArticleTag::where("article_id", $id)->get();

        $comments = Comment::where("article_id", $id)->join("users", "comments.user_id", "=", "users.id")->select("comments.*", "users.name as user_name", "users.avatar as user_avatar") ->orderBy("created_at", "desc")->get();

        $favoriteArticlesCount = UserFavoriteArticles::where("user_id", $article->user_id)->count();


        return view("articles.show", compact("article", "user", "tags", "articleTags", "comments", "favoriteArticlesCount"));
    }

    public function edit($id)
    {
        $article = Article::find($id);


        $tags = ArticleTag::where("article_id", $id)->get();

        return view('articles.edit', compact('article', "tags"));
    }

    public function update(StoreArticleRequest $request, $id)
    {

        if(auth()->guest()) {
            return response()->json(["error" => "Unauthorized"], 401);
        }

        if(auth()->user()->id !== (int)$request->user_id) {
            return response()->json(["error" => "Forbidden"], 403);
        }

        $tags = $request->tags;

        $article = Article::find($id);
        $article->title = $request->title;
        $article->abstract = $request->abstract;
        $article->content = $request->content;
        $article->save();

        $tagModels = [];
        foreach ($tags as $tag) {
            $tagModel = Tag::firstOrCreate(["name" => $tag]);
            $tagModels[] = $tagModel;
        }

        ArticleTag::where("article_id", $id)->delete();

        foreach ($tagModels as $tagModel) {
            ArticleTag::create([
                "article_id" => $article->id,
                "tag_id" => $tagModel->name,
            ]);
        }

        return to_route("articles.show", ["id" => $id]);
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        ArticleTag::where("article_id", $id)->delete();

        return to_route("home");
    }

    public function updateFavorite(Request $request, $id, $user_id)
    {
        $article = Article::find($id);
        $favoriteArticles = UserFavoriteArticles::where("user_id", $user_id)->where("article_id", $id)->first();

        if($favoriteArticles !== null) {
            $article->favorite_count = $article->favorite_count - 1;

            DB::table("user_favorite_articles")->where("user_id", $user_id)->where("article_id", $id)->delete();
        } else {
            $article->favorite_count = $article->favorite_count + 1;
            UserFavoriteArticles::create([
                "user_id" => $user_id,
                "article_id" => $id,
            ]);
        }


        $article->save();

        // ページの更新
        return back();
    }
}

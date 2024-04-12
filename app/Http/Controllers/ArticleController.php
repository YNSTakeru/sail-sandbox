<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;
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

    public function store(Request $request)
    {
        $convertTags = json_decode($request->tags, true);

        $request->merge([
            "tags" => $convertTags,
        ]);


        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
        ]);

        Validator::extend('unique_in_array', function ($attribute, $value, $parameters, $validator) {
            return count($value) === count(array_unique($value));
        });

        // 配列のバリデーション
        $request->validate([
            'tags' => ['required', 'array', 'max:10', 'unique_in_array'],
            'tags.*' => ['string', 'max:255'],
        ]);

        $tagModels = [];
        foreach ($convertTags as $tag) {
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

        return view("articles.show", compact("article", "user", "tags", "articleTags"));
    }

    public function edit($id)
    {
        $article = Article::find($id);


        $tags = ArticleTag::where("article_id", $id)->get();

        return view('articles.edit', compact('article', "tags"));
    }

    public function update(Request $request, $id)
    {
        Validator::extend('unique_in_array', function ($attribute, $value, $parameters, $validator) {
            return count($value) === count(array_unique($value));
        });

        $convertTags = json_decode($request->tags, true);


        $request->merge([
            "tags" => $convertTags,
        ]);

        $request->validate([
            'tags' => ['required', 'array', 'max:10', 'unique_in_array'],
            'tags.*' => ['string', 'max:255'],
        ]);


        $article = Article::find($id);
        $article->title = $request->title;
        $article->abstract = $request->abstract;
        $article->content = $request->content;
        $article->save();

        $tagModels = [];
        foreach ($convertTags as $tag) {
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

        return to_route("home");
    }
}

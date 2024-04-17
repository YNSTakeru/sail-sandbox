<?php

namespace Tests\Feature\ArticleController;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Tests\TestCase;

class ArticleControllerShowTest extends TestCase
{
    public function testCanFetchTheArticle(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();
        $tag = Tag::factory()->create();
        $tags = Tag::all();

        $articleTags = ArticleTag::factory()->create([
            "article_id" => $article->id,
            "tag_id" => $tag->name
        ]);
        $comments = Comment::where("article_id", $article->id)->join("users", "comments.user_id", "=", "users.id")->select("comments.*", "users.name as user_name", "users.avatar as user_avatar") ->orderBy("created_at", "desc")->get();

        $route = route('articles.show', ['id' => 1, "article" => $article, "tags" => $tags, "articleTags" => $articleTags, "comments" => $comments]);

        $response = $this->getJson($route);

        $response->assertOk();
    }
}

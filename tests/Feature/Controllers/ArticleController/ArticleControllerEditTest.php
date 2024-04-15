<?php

namespace Tests\Feature\ArticleController;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ArticleControllerEditTest extends TestCase
{
    public function testCanFetchTheArticle():void
    {

        $user = User::factory()->create();
        $article = Article::factory()->create();
        $tag = Tag::factory()->create();
        $tags = ArticleTag::factory()->create([
            "article_id" => $article->id,
            "tag_id" => $tag->name
        ]);

        $route = route('articles.edit', ['id' => 1, 'article' => $article, 'tags' => $tags]);

        $response = $this->actingAs($user)->getJson($route);

        $response->assertOk();
    }

    public function testCanNotFetchTheArticle():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();
        $tag = Tag::factory()->create();
        $tags = ArticleTag::factory()->create([
            "article_id" => $article->id,
            "tag_id" => $tag->name
        ]);

        $route = route('articles.edit', ['id' => 2, 'article' => $article, 'tags' => $tags]);

        $response = $this->getJson($route);

        $response->assertUnauthorized();
    }
}

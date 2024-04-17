<?php

namespace Tests\Feature\Controllers\ArticleController;

use App\Models\Article;
use App\Models\User;
use App\Models\UserFavoriteArticles;
use Tests\TestCase;

class ArticleControllerUpdateFavoriteTest extends TestCase
{
    public function testCanUpdateFavorite():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user, "author")->create();

        $route = route("articles.updateFavorite", ["id" => $article->id, "user_id", $user->id]);

        $response = $this->actingAs($user)->postJson($route, []);

        $response->assertRedirect();

        $this->assertDatabaseHas("user_favorite_articles", ["user_id" => $user->id, "article_id" => $article->id]);

        $this->assertEquals(1, $article->refresh()->favorite_count);
    }

    public function testCanNotUpdateFavorite():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user, "author")->create();

        $route = route("articles.updateFavorite", ["id" => $article->id, "user_id", $user->id]);

        $response = $this->postJson($route, []);

        $response->assertRedirect();

        $this->assertDatabaseMissing("user_favorite_articles", ["user_id" => $user->id, "article_id" => $article->id]);

        $this->assertEquals(0, $article->refresh()->favorite_count);
    }

    public function testCanUpdateAlreadyFavorite():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user, "author")->create();

        $route = route("articles.updateFavorite", ["id" => $article->id, "user_id", $user->id]);

        $response = $this->actingAs($user)->postJson($route, []);

        $response = $this->actingAs($user)->postJson($route, []);

        $response->assertRedirect();

        $this->assertDatabaseMissing("user_favorite_articles", ["user_id" => $user->id, "article_id" => $article->id]);

        $this->assertEquals(0, $article->refresh()->favorite_count);
    }
}

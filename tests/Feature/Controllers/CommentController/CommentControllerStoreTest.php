<?php

namespace Tests\Feature\Controllers\CommentController;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class CommentControllerStoreTest extends TestCase
{
    public function testCanCreateComment():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $route = route("comments.store", ["id" => $article->id]);

        $response = $this->actingAs($user)->post($route, ["comment" => "hoge"]);

        $this->assertDatabaseHas("comments", ["content" => "hoge", "user_id" => $user->id, "article_id" => $article->id]);
    }

    public function testCommentIsRequired():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $route = route("comments.store", ["id" => $article->id]);

        $response = $this->actingAs($user)->post($route, ["comment" => ""]);

        $response->assertSessionHasErrors('comment');
    }

    public function testCommentIsString():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $route = route("comments.store", ["id" => $article->id]);

        $response = $this->actingAs($user)->post($route, ["comment" => 1]);

        $response->assertSessionHasErrors("comment");
    }

    public function testCommentIsMax255():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $route = route("comments.store", ["id" => $article->id]);

        $response = $this->actingAs($user)->post($route, ["comment" => str_repeat("a", 256)]);

        $response->assertSessionHasErrors("comment");
    }

    public function testCanNotCreateComment():void
    {
        $user = User::factory()->create();
        $accessUser = User::factory()->create();

        $article = Article::factory()->for($user, "author")->create();

        $route = route("comments.store", ["id" => $article->id]);

        $response = $this->post($route, ["comment" => "hoge",
        "user_id" => $accessUser->id,
        "article_id" => $article->id
    ]);

        $response->assertRedirect();
    }
}

<?php

namespace Tests\Feature\Controllers\ArticleController;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;
use Tests\TestCase;

class ArticleControllerUpdateTest extends TestCase
{

    public function testCanUpdateTitle():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user, "author")->create();

        $route = route('articles.update', ['article' => $article, "id" => $article->id]);

        $response = $this->actingAs($user)->putJson($route, ['title' => "hoge",
        "abstract" => $article->abstract,
        "content" => $article->content,
        "user_id" => $user->id,
        "id" => $article->id, "tags" => json_encode(["tag1", "tag2"])]);


        $response->assertRedirect();

        $this->assertEquals("hoge", $article->refresh()->title);
    }

    public function testCanUpdateAbstract(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user, "author")->create();

        $route = route('articles.update', ['article' => $article, "id" => $article->id]);

        $response = $this->actingAs($user)->putJson($route, [
            'title' => $article->title,
            "abstract" => "hoge",
            "content" => $article->content,
            "user_id" => $user->id,
            "id" => $article->id,
            "tags" => json_encode(["tag1", "tag2"])
        ]);

        $response->assertRedirect();

        $this->assertEquals("hoge", $article->refresh()->abstract);
    }

    public function testCanUpdateContent(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user, "author")->create();

        $route = route('articles.update', ['article' => $article, "id" => $article->id]);

        $response = $this->actingAs($user)->putJson($route, [
            'title' => $article->title,
            "abstract" => $article->abstract,
            "content" => "hoge",
            "user_id" => $user->id,
            "id" => $article->id,
            "tags" => json_encode(["tag1", "tag2"])
        ]);

        $response->assertRedirect();

        $this->assertEquals("hoge", $article->refresh()->content);
    }

    public function testCanUpdateTags(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for($user, "author")->create();

        $tags = Tag::factory()->count(2)->create();

        $articleTags = [];

        foreach($tags as $tag) {
            $articleTags [] = ArticleTag::factory()->create([
                "article_id" => $article->id,
                "tag_id" => $tag->name
            ]);
        }


        $route = route('articles.update', ['article' => $article, "id" => $article->id]);

        $response = $this->actingAs($user)->putJson($route, [
            'title' => $article->title,
            "abstract" => $article->abstract,
            "content" => $article->content,
            "user_id" => $user->id,
            "id" => $article->id,
            "tags" => json_encode(["hoge"])
        ]);

        $response->assertRedirect();


        $newArticleTag = ArticleTag::where("article_id", $article->id)->get();

        $this->assertEquals(json_encode(["hoge"]), json_encode([$newArticleTag[0]->tag_id]));
    }


    public function testCanNotUpdateAsGuest(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(
            [
                "user_id" => $user->id
            ]
        );

        $response = $this->putJson(route('articles.update', ['article' => $article, "id" => $article->id]));

        $response->assertUnauthorized();
    }

    public function testNoAccessResponse():void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(
            [
                "user_id" => $user->id
            ]
        );
        $accessUser = User::factory()->create();



        $response = $this->actingAs($accessUser)->putJson(route('articles.update', ['title' => $article->title,
        "abstract" => $article->abstract,
        "content" => $article->content,
        "user_id" => $accessUser->user_id,
        "id" => $article->id, "tags" => json_encode(["tag1", "tag2"])]));


        $response->assertForbidden();
    }
}

<?php

namespace Tests\Feature\ArticleController;

use App\Models\User;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ArticleControllerStoreTest extends TestCase
{
    public function testCanCreateArticle(): void
    {

        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            'title' => 'Test Title',
            "abstract" => "Test Abstract",
            'content' => 'Test Content',
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $this->assertTrue(in_array($response->status(), [201, 302]));


        $this->assertDatabaseHas("articles", [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            "content" => "Test Content",
            "user_id" => $user->id,
            "favorite_count" => 0,
        ]);

        $this->assertDatabaseHas("tags", [
            "name" => "tag1",
        ]);

        $this->assertDatabaseHas("tags", [
            "name" => "tag2",
        ]);

        $this->assertDatabaseHas("article_tags", [
            "article_id" => 1,
            "tag_id" => "tag1",
        ]);

        $this->assertDatabaseHas("article_tags", [
            "article_id" => 1,
            "tag_id" => "tag2",
        ]);
    }

    public function testTitleIsRequired():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "abstract" => "Test Abstract",
            'content' => 'Test Content',
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $response->assertJsonValidationErrors(["title" => __("validation.required", ["attribute" => "記事タイトル"])]);
    }

    public function testCanNotCreateArticlesForUnknownTags():void
    {

    }
}

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

    public function testAbstractIsRequired():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            'content' => 'Test Content',
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $response->assertJsonValidationErrors(["abstract" => __("validation.required", ["attribute" => "記事概要"])]);
    }

    public function testContentIsRequired():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $response->assertJsonValidationErrors(["content" => __("validation.required", ["attribute" => "記事内容"])]);
    }

    public function testTagsIsRequired():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            'content' => 'Test Content',
            "user_id" => $user->id,
            "favorite_count" => 0,
        ]);

        $response->assertJsonValidationErrors(["tags" => __("validation.required", ["attribute" => "タグ"])]);
    }

    public function testTitleIsString():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => 1,
            "abstract" => "Test Abstract",
            'content' => 'Test Content',
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $response->assertJsonValidationErrors(["title" => __("validation.string", ["attribute" => "記事タイトル"])]);
    }

    public function testAbstractIsString():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => 1,
            'content' => 'Test Content',
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $response->assertJsonValidationErrors(["abstract" => __("validation.string", ["attribute" => "記事概要"])]);
    }

    public function testContentIsString():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            'content' => 1,
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $response->assertJsonValidationErrors(["content" => __("validation.string", ["attribute" => "記事内容"])]);
    }

    public function testTagsIsArray():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            'content' => 'Test Content',
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => "tag1",
        ]);

        $response->assertJsonValidationErrors(["tags" => "タグは、必ず指定してください。"]);
    }

    public function testTitleIsMax255():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => str_repeat("a", 256),
            "abstract" => "Test Abstract",
            'content' => 'Test Content',
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $response->assertJsonValidationErrors(["title" => __("validation.max.string", ["attribute" => "記事タイトル", "max" => 255])]);
    }

    public function testAbstractIsMax255():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => str_repeat("a", 256),
            'content' => 'Test Content',
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $response->assertJsonValidationErrors(["abstract" => __("validation.max.string", ["attribute" => "記事概要", "max" => 255])]);
    }

    public function testContentIsMax1000():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            'content' => str_repeat("a", 1001),
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode(["tag1", "tag2"]),
        ]);

        $response->assertJsonValidationErrors(["content" => __("validation.max.string", ["attribute" => "記事内容", "max" => 1000])]);
    }

    public function testIsMaxTags10():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            'content' => "Test Content",
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode([
                "tag1", "tag2", "tag3", "tag4", "tag5", "tag6", "tag7", "tag8", "tag9", "tag10", "tag11"
            ]),
        ]);

        $response->assertJsonValidationErrors(["tags" => __("validation.max.array", ["attribute" => "タグ", "max" => 10])]);
    }

    public function testTagIsString():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            'content' => "Test Content",
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode([
                1, 2
            ]),
        ]);

        $response->assertJsonValidationErrors(
            [
                "tags.0" => __("validation.string", ["attribute" => "tags.0"]),
                "tags.1" => __("validation.string", ["attribute" => "tags.1"]),
            ]
        );
    }

    public function testTagsIsUniqueInArray():void
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            'content' => "Test Content",
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode([
                "tag1", "tag1"
            ]),
        ]);

        $response->assertJsonValidationErrors(["tags" => "タグが重複しています。"]);
    }

    public function testTagIsMax255()
    {
        $user = User::factory()->create();

        $route = route('articles.store');

        $response = $this->actingAs($user)->postJson($route, [
            "title" => "Test Title",
            "abstract" => "Test Abstract",
            'content' => "Test Content",
            "user_id" => $user->id,
            "favorite_count" => 0,
            "tags" => json_encode([
                str_repeat("a", 256)
            ]),
        ]);

        $response->assertJsonValidationErrors(["tags.0" => __("validation.max.string", ["attribute" => "tags.0", "max" => 255])]);
    }
}

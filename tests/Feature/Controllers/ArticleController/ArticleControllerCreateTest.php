<?php

namespace Tests\Feature\ArticleController;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ArticleControllerCreateTest extends TestCase
{
    public function testCanDisplayCreateArticleForm(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('articles.create'));

        $response->assertOk();
    }

    public function testCanNotDisplayCreateArticleForm(): void
    {

        $response = $this->getJson(route('articles.create'));

        $response->assertUnauthorized();
    }
}

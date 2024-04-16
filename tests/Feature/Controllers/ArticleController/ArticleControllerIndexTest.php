<?php

namespace Tests\Feature\ArticleController;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ArticleControllerIndexTest extends TestCase
{
    public function testCanFetchTheArticles():void
    {
        $route = route('home');
        $response = $this->getJson($route);

        // responseの中身を確認
        // $response->dd();

        $response->assertOk();
    }

    public function testCanAuthenticatedUserFetchTheArticles():void
    {
        $user = User::factory()->create();
        Article::factory()->for($user, "author")->create();

        $route = route('home');

        $response = $this->actingAs($user)->getJson($route);
        $response->assertOk();
    }
}

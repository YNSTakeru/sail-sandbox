<?php

namespace Tests\Feature\ArticleController;

use Tests\TestCase;

class ArticleControllerIndexTest extends TestCase
{
    public function testCanFetchTheArticles():void
    {
        $route = route('home');
        $response = $this->getJson($route);

        $response->assertOk();
    }
}

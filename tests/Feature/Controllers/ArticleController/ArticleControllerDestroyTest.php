<?php

namespace Tests\Feature\Controllers\ArticleController;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;
use Tests\TestCase;

class ArticleControllerDestroyTest extends TestCase
{
    public function testCanDestroyCreatedArticle():void
    {

        $user = User::factory()->create();
        $article = Article::factory()->for($user, "author")->create();
        $tags = Tag::factory()->create();

        $articleTags = ArticleTag::factory()->create([
            "article_id" => $article->id,
            "tag_id" => $tags->name
        ]);

        $route = route('articles.destroy', [ "id" => $article->id]);

        $response = $this->actingAs($user)->deleteJson($route);

        $response->assertRedirect();

        $this->assertDatabaseMissing('articles', $article->toArray());

        $this->assertDatabaseMissing('article_tags', $articleTags->toArray());
    }
}

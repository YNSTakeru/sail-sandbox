<?php

namespace Tests\Feature\ProfileController;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserFavoriteArticles;
use Tests\TestCase;

class ProfileControllerIndexTest extends TestCase
{
    public function testCanFetchArticles():void
    {

        $user = User::factory()->create();
        $profile = Profile::factory()->create(
            [
                "user_id" => $user->id
            ]
        );

        $articles = Article::factory()->count(3)->create([
            "user_id" => $user->id
        ]);

        $tag = Tag::factory()->create();

        foreach ($articles as $article) {
            $articleTags = ArticleTag::factory()->create([
                "article_id" => $article->id,
                "tag_id" => $tag->name
            ]);
        }

        $articleTags = Article::select("article_tags.*")->where('user_id', $user->id)->orderBy('created_at', 'desc')->join('article_tags', 'articles.id', '=', 'article_tags.article_id')->get();



        $route = route('profile', ['id' => $user->id, 'profile' => $profile, 'articles' => $articles, 'articleTags' => $articleTags, "user" => $user]);

        $response = $this->actingAs($user)->getJson($route);

        $response->assertOk();
    }
}

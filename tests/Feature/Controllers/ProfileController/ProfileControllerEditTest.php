<?php

namespace Tests\Feature\ProfileController;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;
use Tests\TestCase;

class ProfileControllerEditTest extends TestCase
{
    public function testCanFetchTheProfile():void
    {

        $user = User::factory()->create();
        $profile = Profile::factory()->create(
            [
                "user_id" => $user->id
            ]
        );

        $route = route('settings', ['user' => $user, "profile" => $profile]);

        $response = $this->actingAs($user)->getJson($route);

        $response->assertOk();
    }

    public function testCanNotFetchTheProfile():void
    {

        $user = User::factory()->create();
        $profile = Profile::factory()->create(
            [
                "user_id" => $user->id
            ]
        );

        $route = route('settings', ['user' => $user, "profile" => $profile]);

        $response = $this->getJson($route);

        $response->assertUnauthorized();
    }


}

<?php

namespace Tests\Feature\Controllers\ProfileController;

use App\Models\Article;
use App\Models\Profile;
use App\Models\User;
use Tests\TestCase;

class ProfileControllerUpdateTest extends TestCase
{
    public function testCanUpdateURL():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name, "email" => $user->email, "avatar" => "https://google.com", "bio" => $profile->bio, "password" => $user->password
        ]);

        $response->assertRedirect();

        $this->assertEquals("https://google.com", $user->refresh()->avatar);
    }

    public function testCanUpdateBio(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name, "email" => $user->email, "avatar" => $user->avatar, "bio" => "hoge", "password" => $user->password
        ]);

        $response->assertRedirect();

        $this->assertEquals("hoge", $profile->refresh()->bio);
    }

    public function testCanUpdateName(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => "hoge", "email" => $user->email, "avatar" => $user->avatar, "bio" => $profile->bio, "password" => $user->password
        ]);

        $response->assertRedirect();

        $this->assertEquals("hoge", $user->refresh()->name);
    }

    public function testCanUpdateEmail(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => "hoge@gmail.com",
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertRedirect();

        $this->assertEquals("hoge@gmail.com", $user->refresh()->email);
    }

    public function testCanUpdatePassword(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => $user->email,
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => "hoge"
        ]);

        $response->assertRedirect();

        $this->assertTrue(password_verify("hoge", $user->refresh()->password));
    }

    public function testNameIsRequired(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => "",
            "email" => $user->email,
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testEmailIsRequired(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => "",
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testNameIsString():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => 1,
            "email" => $user->email,
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testNameIsMax255():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => str_repeat("a", 256),
            "email" => $user->email,
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testBioIsString():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => $user->email,
            "avatar" => $user->avatar,
            "bio" => 1,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testBioIsMax255():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => $user->email,
            "avatar" => $user->avatar,
            "bio" => str_repeat("a", 256),
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testAvatarIsURL():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => $user->email,
            "avatar" => "hoge",
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testAvatarIsMax255():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => $user->email,
            "avatar" => str_repeat("a", 256),
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testEmailIsLowercase(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => "AAA@gmail.com",
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testEmailIsEmail(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => "hoge",
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testEmailIsString():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => 1,
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testEmailIsMax255():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => str_repeat("a", 256),
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }

    public function testEmailIsUnique():void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $profile = Profile::factory()->for($user1, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user1)->putJson($route, [
            "name" => $user1->name,
            "email" => $user2->email,
            "avatar" => $user1->avatar,
            "bio" => $profile->bio,
            "password" => $user1->password
        ]);

        $response->assertStatus(422);
    }

    public function testEmailIsBeforeEmail():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $route = route('profile.update');

        $response = $this->actingAs($user)->putJson($route, [
            "name" => $user->name,
            "email" => $user->email,
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertRedirect();

        $this->assertEquals($user->email, $user->refresh()->email);
    }

    public function testCanNotUpdateAsGuest():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();

        $response = $this->putJson(route('profile.update'), [
            "name" => $user->name,
            "email" => $user->email,
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertUnauthorized();
    }

    public function testNoAccessResponse():void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user, "user")->create();
        $accessUser = User::factory()->create();

        $response = $this->actingAs($accessUser)->putJson(route('profile.update'), [
            "name" => $user->name,
            "email" => $user->email,
            "avatar" => $user->avatar,
            "bio" => $profile->bio,
            "password" => $user->password
        ]);

        $response->assertStatus(422);
    }
}

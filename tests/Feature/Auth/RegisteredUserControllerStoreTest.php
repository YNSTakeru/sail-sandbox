<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisteredUserControllerStoreTest extends TestCase
{

    public function testCanRegisterUser(): void
    {

        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'aaa@gmail.com',
            'password' => 'password',
        ]);

        $this->assertTrue(in_array($response->status(), [201, 302]));


        $this->assertDatabaseHas("users", [
            "name" => "John Doe",
            "email" => "aaa@gmail.com",
        ]);

        $user = User::where("email", "aaa@gmail.com")->first();

        $this->assertTrue(Hash::check("password", $user->password));
    }

    public function testNameIsRequired(): void
    {
        $response = $this->postJson(route('register'), [
            'email' => 'aaa@gmail.com',
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(["name" => __("validation.required", ["attribute" => "名前"])]);
    }

    public function testEmailIsRequired(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => 'John Doe',
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(["email" => __("validation.required", ["attribute" => "メールアドレス"])]);
    }

    public function testPassowrdIsRequired(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => 'John Doe',
            'email' => 'aaa@gmail.com'
        ]);

        $response->assertJsonValidationErrors(["password" => __("validation.required", ["attribute" => "パスワード"])]);
    }

    public function testNameIsString(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => 123,
            'email' => 'aaa@gmail.com',
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(["name" => __("validation.string", ["attribute" => "名前"])]);
    }

    public function testEmailIsString():void
    {
        $response = $this->postJson(route('register'), [
            'name' => 'John Doe',
            'email' => 123,
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(["email" => __("validation.string", ["attribute" => "メールアドレス"])]);
    }

    public function testNameIsMax255(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => str_repeat("a", 256),
            'email' => 'aaa@gmail.com',
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(["name" => __("validation.max.string", ["attribute" => "名前", "max" => 255])]);
    }

    public function testEmailIsLowcase(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => 'John Doe',
            'email' => 'AAA@gmail.com',
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(["email" =>"メールアドレスは小文字で指定してください。"]);
    }

    public function testEmailIsEmail(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => 'John Doe',
            'email' => 'aaa',
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(["email" => __("validation.email", ["attribute" => "メールアドレス"])]);
    }

    public function testEmailIsMax255(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => 'John Doe',
            'email' => str_repeat("a", 256)."@gmail.com",
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(["email" => __("validation.max.string", ["attribute" => "メールアドレス", "max" => 255])]);
    }

    public function testEmailIsUnique(): void
    {
        User::factory()->create([
            "email" => "aaa@gmail.com"
        ]);

        $response = $this->postJson(route('register'), [
            'name' => 'John Doe',
            'email' => 'aaa@gmail.com',
            'password' => 'password',
        ]);

        $response->assertJsonValidationErrors(["email" => __("validation.unique", ["attribute" => "メールアドレス"])]);
    }
}

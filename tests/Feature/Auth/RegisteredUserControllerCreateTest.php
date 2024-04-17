<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class RegisteredUserControllerCreateTest extends TestCase
{
    public function testCanDisplayRegisterForm(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk();
    }

    public function testCanNotDisplayRegisterForm(): void
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('register'));

        $response->assertRedirect();
    }
}

<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route("logout"));

        $response->assertStatus(302);
        $response->assertRedirect(route("login"));
    }

    public function test_logout_if_user_not_login(){
        $response = $this->post(route("logout"));

        $response->assertStatus(302);
        $response->assertRedirect(route("login"));
    }
}

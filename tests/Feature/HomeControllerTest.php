<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_access_home_if_user_login(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route("home"));

        $response->assertStatus(200);
    }

    public function test_access_home_if_user_not_login()
    {
        $response = $this->get(route("home"));

        $response->assertStatus(302);
        $response->assertRedirect(route("login"));
    }
}

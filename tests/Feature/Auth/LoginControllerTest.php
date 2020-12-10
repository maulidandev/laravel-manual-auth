<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAccessLoginPage()
    {
        $response = $this->get('login');

        $response->assertStatus(200);
    }

    public function testLoginWithValidData(){
        $response = $this->from("login")
            ->post("login", $this->getData());

        $response->assertStatus(302);
        $response->assertRedirect(route("home"));
    }

    /**
     * @param $error
     * @param $data
     * @dataProvider loginInvalidData
     */
    public function testLoginWithInvalidData($error, $data){
        $response = $this->from("login")
            ->post("login", $this->getData($data));

        $response->assertStatus(302);
        $response->assertSessionHasErrors($error);
        $response->assertRedirect(route("login"));
    }

    public function loginInvalidData(){
        return [
            [["email"], ["email" => ""]],
            [["email"], ["email" => "notfound@email.com"]],
            [["email"], ["email" => "invalid"]],
            [["email"], ["email" => str_repeat("invalid", 32) . "@gmail.com"]],

            [["password"], ["password" => ""]],
            [["password"], ["password" => "123"]],
        ];
    }

    public function getData($overrides = []){
        $password = "123123";
        $user = User::factory()->state([
            "password" => bcrypt($password)
        ])->create();

        return array_merge([
            "email" => $user->email,
            "password" => $password
        ], $overrides);
    }
}

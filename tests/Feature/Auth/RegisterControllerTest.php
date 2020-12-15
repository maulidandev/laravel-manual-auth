<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function testAccessRegisterPage()
    {
        $response = $this->get('register');

        $response->assertStatus(200);
    }

    public function test_access_register_page_if_user_login(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route("register"));

        $response->assertStatus(302);
        $response->assertRedirect(route("home"));
    }

    /**
     * @test
     */
    public function testRegisterWithValidData(){
        $data = $this->getData();
        $response = $this->from("register")
            ->post("register", $data);

        $this->assertDatabaseHas("users", [
            "email" => $data["email"]
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route("login"));
    }

    /**
     * @param $error
     * @param $data
     * @dataProvider registerInvalidData
     */
    public function testRegisterWithInvalidData($error, $data){
        $response = $this->from("register")
            ->post("register", $this->getData($data));

        $response->assertStatus(302);
        $response->assertSessionHasErrors($error);
        $response->assertRedirect(route("register"));
    }

    /**
     * @return array
     */
    public function registerInvalidData(){
        return [
            [["name"], ["name" => ""]],
            [["name"], ["name" => str_repeat("john doe", 32)]],

            [["email"], ["email" => ""]],
            [["email"], ["email" => "email"]],
            [["email"], ["email" => str_repeat("emailemail", 32) . "@gmail.com"]],

            [["password"], ["password" => ""]],
            [["password"], ["password_confirmation" => ""]]
        ];
    }

    /**
     * @param array $overrides
     * @return array
     */
    private function getData($overrides = []){
        $user = User::factory()->state([
            "password" => "123123"
        ])->make();

        return array_merge([
            "name" => $user->name,
            "email" => $user->email,
            "password" => "password",
            "password_confirmation" => "password"
        ], $overrides);
    }
}

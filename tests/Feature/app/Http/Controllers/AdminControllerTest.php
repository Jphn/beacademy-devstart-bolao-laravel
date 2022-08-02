<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testInvalidAdminUserCanNotLogin()
    {
        // PREPARE
        $invalidUser = User::factory()->definition();

        // ACT
        $response = $this->post(route('login.post'), $invalidUser);

        // ASSERT
        $response->assertStatus(303);
        $response->assertRedirect(url()->previous());
    }

    public function testValidAdminUserCanNotLoginUsingWrongPassword()
    {
        // PREPARE
        $validUser = User::factory()->create(['password' => bcrypt('rightPassword')]);
        $payload = [
            'email' => $validUser->email,
            'password' => 'wrongPassword'
        ];

        // ACT
        $response = $this->post(route('login.post'), $payload);

        // ASSERT
        $response->assertStatus(303);
        $response->assertRedirect(url()->previous());
    }

    public function testValidAdminUserCanLogin()
    {
        // PREPARE
        $validUser = User::factory()->create(['password' => bcrypt('password')]);
        $payload = [
            'email' => $validUser->email,
            'password' => 'password'
        ];

        // ACT
        $response = $this->post(route('login.post'), $payload);

        // ASSERT
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.dashboard'));
    }
}

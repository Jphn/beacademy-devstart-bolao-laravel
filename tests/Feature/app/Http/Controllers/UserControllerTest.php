<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testNotAuthenticatedUserCanNotCreateANewAdminUser()
    {
        // PREPARE
        $payload = [
            'name' => 'Valid Name',
            'email' => 'valid@email.com',
            'password' => 'password'
        ];

        // ACT
        $this->post(route('users.create'), $payload);

        // ASSERT
        $this->assertDatabaseCount(User::class , 0);
        $this->assertDatabaseMissing(User::class , [
            'email' => $payload['email']
        ]);
    }

    public function testAdminCanCreateANewAdminUser()
    {
        // PREPARE
        $user = User::factory()->create();
        $payload = [
            'name' => 'Valid Name',
            'email' => 'valid@email.com',
            'password' => 'password'
        ];

        // ACT
        $this->actingAs($user);
        $this->post(route('users.create'), $payload);

        // ASSERT
        $this->assertDatabaseCount(User::class , 2);
        $this->assertDatabaseHas(User::class , [
            'email' => $payload['email']
        ]);
    }

    public function testAdminCanNotCreateANewAdminUserWhenSendingWrongParameters()
    {
        // PREPARE
        $user = User::factory()->create();
        $payload = [
            'name' => '',
            'email' => '',
            'password' => ''
        ];

        // ACT
        $this->actingAs($user);
        $this->post(route('users.create'), $payload);

        // ASSERT
        $this->assertDatabaseCount(User::class , 1);
    }

    public function testNotAuthenticatedUserCanNotUpdateAdminUserData()
    {
        // PREPARE
        $anotherUser = User::factory()->create();
        $payload = [
            'name' => 'New Name',
            'email' => 'new@email.com'
        ];

        // ACT
        $this->put(route('users.update', $anotherUser->id), $payload);

        // ASSERT
        $this->assertDatabaseCount(User::class , 1);
        $this->assertDatabaseMissing(User::class , [
            'name' => $payload['name'],
            'email' => $payload['email']
        ]);
        $this->assertDatabaseHas(User::class , [
            'name' => $anotherUser->name,
            'email' => $anotherUser->email
        ]);
    }

    public function testAdminCanUpdateAdminUserData()
    {
        // PREPARE
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $payload = [
            'name' => 'New Name',
            'email' => 'new@email.com'
        ];

        // ACT
        $this->actingAs($user);
        $this->put(route('users.update', $anotherUser->id), $payload);

        // ASSERT
        $this->assertDatabaseCount(User::class , 2);
        $this->assertDatabaseHas(User::class , [
            'name' => $payload['name'],
            'email' => $payload['email']
        ]);
        $this->assertDatabaseMissing(User::class , [
            'name' => $anotherUser->name,
            'email' => $anotherUser->email
        ]);
    }

    public function testAdminCanNotUpdateAdminUserDataWhenSendingWrongParameters()
    {
        // PREPARE
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $payload = [
            'name' => '',
            'email' => ''
        ];

        // ACT
        $this->actingAs($user);
        $this->put(route('users.update', $anotherUser->id), $payload);

        // ASSERT
        $this->assertDatabaseCount(User::class , 2);
        $this->assertDatabaseMissing(User::class , [
            'name' => $payload['name'],
            'email' => $payload['email']
        ]);
        $this->assertDatabaseHas(User::class , [
            'name' => $anotherUser->name,
            'email' => $anotherUser->email
        ]);
    }

    public function testAdminCanDeleteAdminUser()
    {
        // PREPARE
        $payload = User::factory()->create();
        $user = User::factory()->create();

        // ACT
        $this->actingAs($user);
        $this->delete(route('users.delete', $payload->id));

        // ASSERT
        $this->assertDatabaseCount(User::class , 1);
        $this->assertDatabaseMissing(User::class , [
            'id' => $payload->id
        ]);
        $this->assertDatabaseHas(User::class , [
            'id' => $user->id
        ]);
    }

    public function testAdminCanNotDeleteHisOwnUser()
    {
        // PREPARE
        $user = User::factory()->create();

        // ACT
        $this->actingAs($user);
        $this->delete(route('users.delete', $user->id));

        // ASSERT
        $this->assertDatabaseCount(User::class , 1);
        $this->assertDatabaseHas(User::class , [
            'id' => $user->id
        ]);
    }

    public function testNotAuthenticatedUserCanNotDeleteAdminUser()
    {
        // PREPARE
        $payload = User::factory()->create();

        // ACT
        $this->delete(route('users.delete', $payload->id));

        // ASSERT
        $this->assertDatabaseCount(User::class , 1);
        $this->assertDatabaseHas(User::class , [
            'id' => $payload->id
        ]);
    }
}

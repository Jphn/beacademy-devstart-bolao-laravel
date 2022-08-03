<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Participant;

class ParticipantControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanNotCreateANewParticipantWhenSendingInvalidParameters()
    {
        // PREPARE
        $user = User::factory()->create();
        $payload = [];

        // ACT
        $this->actingAs($user);
        $this->post(route('participants.create'), $payload);

        // ASSERT
        $this->assertDatabaseCount(Participant::class , 0);
    }

    public function testNotAuthenticatedUserCanNotCreateANewParticipant()
    {
        // PREPARE
        $payload = Participant::factory()->definition();

        // ACT
        $this->post(route('participants.create'), $payload);

        // ASSERT
        $this->assertDatabaseCount(Participant::class , 0);
    }

    public function testAuthenticatedAdminUserCanCreateANewParticipant()
    {
        // PREPARE
        $user = User::factory()->create();
        $payload = [
            'name' => 'Teste',
            'phone' => '88888888888',
            'active' => 'on',
            'password' => 'password'
        ];

        // ACT
        $this->actingAs($user);
        $this->post(route('participants.create'), $payload);

        // ASSERT
        $this->assertDatabaseCount(Participant::class , 1);
    }

    public function testNotAuthenticatedUserCanNotResetParticipants()
    {
        // PREPARE
        $participant = Participant::factory()->create(['points' => 10, 'update_number' => 1000]);

        // ACT
        $this->put(route('participants.reset'));

        // ASSERT
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertDatabaseMissing(Participant::class , [
            'id' => $participant->id,
            'points' => 0,
            'update_number' => 0,
        ]);
        $this->assertDatabaseHas(Participant::class , [
            'id' => $participant->id,
            'points' => $participant->points,
            'update_number' => $participant->update_number
        ]);
    }

    public function testAdminCanResetParticipants()
    {
        // PREPARE
        $user = User::factory()->create();
        $participant = Participant::factory()->create(['points' => 10, 'update_number' => 1000]);

        // ACT
        $this->actingAs($user);
        $this->put(route('participants.reset'));

        // ASSERT
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertDatabaseHas(Participant::class , [
            'id' => $participant->id,
            'points' => 0,
            'update_number' => 0,
        ]);
        $this->assertDatabaseMissing(Participant::class , [
            'id' => $participant->id,
            'points' => $participant->points,
            'update_number' => $participant->update_number
        ]);
    }

    public function testNotAuthenticatedUserCanNotEditParticipantInfos()
    {
        // PREPARE
        $participant = Participant::factory()->create();
        $payload = [
            'name' => 'Updated Name',
            'phone' => 00000000000
        ];

        // ACT
        $this->put(route('participants.update', $participant->id), $payload);

        // ASSERT
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertDatabaseHas(Participant::class , [
            'id' => $participant->id,
            'name' => $participant->name,
            'phone' => $participant->phone
        ]);
        $this->assertDatabaseMissing(Participant::class , $payload);
    }

    public function testAdminCanEditParticipantInfos()
    {
        // PREPARE
        $user = User::factory()->create();
        $participant = Participant::factory()->create();
        $payload = [
            'name' => 'Updated Name',
            'phone' => '00000000000'
        ];

        // ACT
        $this->actingAs($user);
        $this->put(route('participants.update', $participant->id), $payload);

        // ASSERT
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertDatabaseHas(Participant::class , $payload);
        $this->assertDatabaseMissing(Participant::class , [
            'id' => $participant->id,
            'name' => $participant->name,
            'phone' => $participant->phone
        ]);
    }

    public function testAdminCanNotUpdateANonexistentParticipant()
    {
        // PREPARE
        $user = User::factory()->create();
        $participant = Participant::factory()->create();
        $payload = [
            'name' => 'Updated Name',
            'phone' => '00000000000'
        ];

        // ACT
        $this->actingAs($user);
        $response = $this->put(route('participants.update', $participant->id + 1), $payload);

        // ASSERT
        $response->assertStatus(404);
        $this->assertDatabaseCount(Participant::class , 1);
    }

    public function testAdminCanNotUpdateAParticipantSendingEmptyParameters()
    {
        // PREPARE
        $user = User::factory()->create();
        $participant = Participant::factory()->create();
        $payload = [];

        // ACT
        $this->actingAs($user);
        $response = $this->put(route('participants.update', $participant->id), $payload);

        // ASSERT
        $response->assertStatus(302);
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertDatabaseHas(Participant::class , [
            'id' => $participant->id,
            'name' => $participant->name,
            'phone' => $participant->phone
        ]);
    }

    public function testParticipantCanSelectHisDozens()
    {
        // PREPARE
        $participant = Participant::factory()->create(['dozens' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'password' => bcrypt('password')]);
        $payload = [
            'dozens' => '[1, 12, 23, 34, 45, 56, 47, 38, 29, 20]',
            'password' => 'password'
        ];

        // ACT
        $response = $this->put(route('participants.update.dozens', $participant->id), $payload);

        // ASSERT
        $participant = Participant::find($participant->id);

        $response->assertRedirect(url()->previous());
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertEquals(json_decode($payload['dozens']), $participant->dozens);
    }

    public function testParticipantCanNotSelectDozensUsingWrongPassword()
    {
        // PREPARE
        $participant = Participant::factory()->create(['dozens' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'password' => bcrypt('password')]);
        $payload = [
            'dozens' => '[1, 12, 23, 34, 45, 56, 47, 38, 29, 20]',
            'password' => 'wrongPassword'
        ];

        // ACT
        $response = $this->put(route('participants.update.dozens', $participant->id), $payload);

        // ASSERT
        $participant = Participant::find($participant->id);

        $response->assertRedirect(url()->previous());
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertNotEquals(json_decode($payload['dozens']), $participant->dozens);
    }

    public function testParticipantCanNotSelectANumberThatIsOutOfRange()
    {
        // PREPARE
        $participant = Participant::factory()->create(['dozens' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'password' => bcrypt('password')]);
        $payload = [
            'dozens' => '[61, 12, 23, 34, 45, 56, 47, 38, 29, 0]',
            'password' => 'password'
        ];

        // ACT
        $response = $this->put(route('participants.update.dozens', $participant->id), $payload);

        // ASSERT
        $participant = Participant::find($participant->id);

        $response->assertRedirect(url()->previous());
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertNotEquals(json_decode($payload['dozens']), $participant->dozens);
    }

    public function testNotAuthenticatedUserCanNotDeleteParticipant()
    {
        // PREPARE
        $participant = Participant::factory()->create();

        // ACT
        $this->delete(route('participants.delete', $participant->id));

        // ASSERT
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertDatabaseHas(Participant::class , [
            'id' => $participant->id
        ]);
    }

    public function testAdminCanDeleteParticipant()
    {
        // PREPARE
        $user = User::factory()->create();
        $participant = Participant::factory()->create();

        // ACT
        $this->actingAs($user);
        $this->delete(route('participants.delete', $participant->id));

        // ASSERT
        $this->assertDatabaseCount(Participant::class , 0);
        $this->assertDatabaseMissing(Participant::class , [
            'id' => $participant->id
        ]);
    }
}

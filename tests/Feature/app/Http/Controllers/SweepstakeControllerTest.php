<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Participant;
use App\Models\Sweepstake;
use Illuminate\Support\Facades\Http;

class SweepstakeControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminCanAutoUpdateAllParticipantsPoints()
    {
        // PREPARE
        $result = Http::withoutVerifying()->get('https://loteriascaixa-api.herokuapp.com/api/mega-sena/latest')->json();
        $user = User::factory()->create();
        $participant = Participant::factory()->create();

        // ACT
        $this->actingAs($user);
        $response = $this->put(route('sweepstakes.update'));

        // ASSERT
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertDatabaseCount(Sweepstake::class , 1);
        $this->assertDatabaseMissing(Participant::class , [
            'update_number' => $participant->update_number
        ]);
        $this->assertDatabaseHas(Participant::class , [
            'update_number' => $result['concurso']
        ]);
        $this->assertDatabaseHas(Sweepstake::class , [
            'id' => $result['concurso'],
        ]);
    }

    public function testNotAuthenticatedUserCanNotAutoUpdateAllParticipantsPoints()
    {
        // PREPARE
        $result = Http::withoutVerifying()->get('https://loteriascaixa-api.herokuapp.com/api/mega-sena/latest')->json();
        $participant = Participant::factory()->create();

        // ACT
        $response = $this->put(route('sweepstakes.update'));

        // ASSERT
        $response->assertRedirect(route('login'));

        $this->assertDatabaseCount(Participant::class , 1);
        $this->assertDatabaseMissing(Participant::class , [
            'update_number' => $result['concurso']
        ]);
        $this->assertDatabaseHas(Participant::class , [
            'update_number' => $participant->update_number
        ]);

        $this->assertDatabaseCount(Sweepstake::class , 0);
        $this->assertDatabaseMissing(Sweepstake::class , [
            'id' => $result['concurso'],
        ]);
    }
}

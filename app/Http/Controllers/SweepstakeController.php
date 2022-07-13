<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Sweepstake;
use App\Models\Participant;

class SweepstakeController extends Controller
{
    public function __construct(Sweepstake $sweepstake, Participant $participant)
    {
        $this->sweepstake = $sweepstake;
        $this->participant = $participant;
    }

    public function putLatestSweepstake()
    {
        $result = Http::withoutVerifying()->get('https://loteriascaixa-api.herokuapp.com/api/mega-sena/latest')->json(); // FIXME - Debug only.

        $data = [
            'id' => $result['concurso'],
            'dozens' => $result['dezenas'],
            'next_date' => date('Y-m-d', strtotime(str_replace('/', '-', $result['dataProxConcurso'])))
        ];

        $this->participant->updateParticipantsPoints($data['id'], $data['dozens']);

        if (Sweepstake::find($data['id']) == null)
            $this->sweepstake->create($data);

        return redirect()->route('admin.dashboard');
    }
}

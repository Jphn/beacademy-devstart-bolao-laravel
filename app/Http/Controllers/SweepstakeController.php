<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Sweepstake;

class SweepstakeController extends Controller
{
    public function __construct(Sweepstake $model)
    {
        $this->model = $model;
    }

    public function putLatestSweepstake()
    {
        $result = Http::withoutVerifying()->get('https://loteriascaixa-api.herokuapp.com/api/mega-sena/latest')->json(); // FIXME - Debug only.

        $data = [
            'id' => $result['concurso'],
            'dozens' => json_encode($result['dezenas']),
            'next_date' => date('Y-m-d', strtotime(str_replace('/', '-', $result['dataProxConcurso'])))
        ];

        if (Sweepstake::find($data['id']) == null)
            $this->model->create($data);

        return redirect()->route('admin.dashboard');
    }
}

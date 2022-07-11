<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Http\Requests\ParticipantsRequest;

class ParticipantController extends Controller
{
    public function __construct(Participant $model)
    {
        $this->model = $model;
    }

    public function postParticipant(Request $req)
    {
        $data = $req->only('name', 'phone');

        $this->model->create($data);

        return redirect()->route('admin.dashboard');
    }

    public function putParticipant(ParticipantsRequest $req, $id)
    {
        $data = $req->only('name', 'phone');

        if ($participant = $this->model->find($id))
            $participant->update($data);

        return redirect()->route('admin.dashboard');
    }

    public function deleteParticipant(Request $req, $id)
    {
        if ($participant = $this->model->find($id))
            $participant->delete();

        return redirect()->route('admin.dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Http\Requests\ParticipantsRequest;

class ParticipantController extends Controller
{
    public function __construct(Participant $model)
    {
        $this->model = $model;
    }

    public function postParticipant(ParticipantsRequest $req)
    {
        $data = $req->only('name', 'phone');
        $data['password'] = bcrypt($req->password);
        $data['dozens'] = json_encode([0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);

        $this->model->create($data);

        return redirect()->route('admin.dashboard');
    }

    public function putParticipant(ParticipantsRequest $req, $id)
    {
        $data = $req->only('name', 'phone');

        if ($req->active == 'on')
            $data['active'] = true;

        if ($req->password)
            $data['password'] = bcrypt($req->password);

        if ($participant = $this->model->find($id))
            $participant->update($data);

        return redirect()->route('admin.dashboard');
    }

    public function deleteParticipant($id)
    {
        if ($participant = $this->model->find($id))
            $participant->delete();

        return redirect()->route('admin.dashboard');
    }
}

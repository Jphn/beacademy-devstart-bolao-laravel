<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Http\Requests\ParticipantsRequest;
use Symfony\Component\HttpFoundation\Request;

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
        $data['dozens'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        $this->model->create($data);

        return redirect()->route('admin.dashboard');
    }

    public function putResetParticipants()
    {
        $this->model->where('active', true)->update([
            'points' => 0,
            'update_number' => 0,
            'dozens' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        ]);

        return redirect()->back();
    }

    public function putParticipant(ParticipantsRequest $req, $id)
    {
        $data = $req->only('name', 'phone');
        $data['active'] = (bool)$req->active ?? false;

        if ($req->password)
            $data['password'] = bcrypt($req->password);

        if ($participant = $this->model->find($id))
            $participant->update($data);

        return redirect()->route('admin.dashboard');
    }

    public function putParticipantDozens(Request $req, $id)
    {
        $dozens = json_decode($req->dozens);

        if (count(array_unique($dozens)) == 10)
            $participant = $this->model->find($id);

        if ($participant && password_verify($req->password, $participant->password))
            $participant->update([
                'dozens' => $req->dozens
            ]);

        return redirect()->back();
    }

    public function deleteParticipant($id)
    {
        if ($participant = $this->model->find($id))
            $participant->delete();

        return redirect()->route('admin.dashboard');
    }
}

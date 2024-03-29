<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipantsRequest;
use App\Models\Participant;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;

class ParticipantController extends Controller
{
	public function __construct(Participant $model)
	{
		$this->model = $model;
	}

	public function getParticipantsCsv()
	{
		$file = fopen(public_path('storage/participants.csv'), 'w');

		fputcsv($file, [
			'PARTICIPANTE',
			'PONTUAÇÃO',
			'CONCURSO',
			'DEZENAS'
		]);

		$this->model->orderByDesc('points')->where('active', true)->chunk(2000, function ($participants) use ($file) {
			foreach ($participants->toArray() as $participant) {
				unset($participant['id'], $participant['dozens'], $participant['active'], $participant['phone']);
				fputcsv($file, $participant);
			}
		});

		fclose($file);

		return Storage::disk('public')->download('participants.csv', date('d-m-Y') . '.csv');
	}

	public function postParticipant(ParticipantsRequest $req)
	{
		$data = $req->only('name', 'phone');

		$data['active'] = (bool)$req->active ?? false;
		$data['password'] = bcrypt($req->password);
		$data['dozens'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

		$this->model->create($data);

		return redirect()->route('admin.dashboard');
	}

	public function putResetParticipants()
	{
		$this->model->query()->update([
			'points' => 0,
			'update_number' => 0,
			'dozens' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
		]);

		return redirect()->back();
	}

	public function putParticipant(ParticipantsRequest $req, $id)
	{
		$participant = $this->model->findOrFail($id);

		$data = $req->only('name', 'phone');
		$data['active'] = (bool)$req->active ?? false;

		if ($req->password)
			$data['password'] = bcrypt($req->password);

		$participant->update($data);

		return redirect()->route('admin.dashboard');
	}

	public function putParticipantDozens(Request $req, $id)
	{
		$participant = $this->model->find($id);

		$dozens = array_unique(json_decode($req->dozens));

		$dozens = array_filter($dozens, function ($value) {
			return 1 <= $value && $value <= 60;
		});

		if (count($dozens) == 10 && password_verify($req->password, $participant->password))
			$participant->update([
				'dozens' => $dozens
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

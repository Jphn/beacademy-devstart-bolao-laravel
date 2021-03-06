<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Sweepstake;

class IndexController extends Controller
{
	public function __construct(Participant $participant, Sweepstake $sweepstake)
	{
		$this->participant = $participant;
		$this->sweepstake = $sweepstake;
	}

	public function getTablePage()
	{
		$participants = $this->participant->orderByDesc('points')->where('active', true)->get();

		$sweepstake = $this->sweepstake->orderBy('id', 'DESC')->first();

		return view('table', compact('participants', 'sweepstake'));
	}

	public function getWheelPage($id)
	{
		$modelDozens = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

		$participant = $this->participant->where('active', true)->find($id);

		if (!$participant || count(array_diff($participant->dozens, $modelDozens)) == 10)
			return redirect()->route('index.table');

		return view('wheel', compact('id'));
	}
}

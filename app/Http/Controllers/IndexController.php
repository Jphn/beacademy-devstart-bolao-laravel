<?php

namespace App\Http\Controllers;

use App\Models\Participant;

class IndexController extends Controller
{
	public function __construct(Participant $participant)
	{
		$this->participant = $participant;
	}

	public function getTablePage()
	{
		$participants = $this->participant->orderByDesc('points')->where('active', true)->get();

		return view('table', compact('participants'));
	}

	public function getWheelPage($id)
	{
		$modelDozens = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

		$participant = $this->participant->where('active', true)->find($id);

		if (!$participant || count(array_diff(json_decode($participant->dozens), $modelDozens)) == 10)
			return redirect()->route('index.table');

		return view('wheel', compact('id'));
	}
}

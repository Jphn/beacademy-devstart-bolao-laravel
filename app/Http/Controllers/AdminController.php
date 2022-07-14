<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Participant;

class AdminController extends Controller
{
	public function getLoginPage()
	{
		return view('admin.login');
	}

	public function postLogin(Request $req)
	{
		$queryParams = $req->only('email', 'password');

		if (!$user = User::where('email', $queryParams['email'])->get()[0] ?? null)
			return redirect()->route('admin.login');

		if (!password_verify($queryParams['password'], $user->password))
			return redirect()->route('admin.login');

		session([
			'login' => [
				'name' => $user->name,
				'email' => $user->email,
				'timestamp' => new \DateTime('America/Sao_Paulo')
			]
		]);

		return redirect()->route('admin.dashboard');
	}

	public function getDashboardPage()
	{
		$participants = Participant::all();

		return view('admin.dashboard', compact('participants'));
	}

	public function getLogoutUser()
	{
		session()->flush();

		return redirect()->route('index.table');
	}

	public function getParticipantEditPage($id)
	{
		if ($participant = Participant::find($id))
			return view('participant.edit', compact('participant'));

		return redirect()->route('admin.dashboard');
	}
}

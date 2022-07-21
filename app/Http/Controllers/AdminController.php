<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
	public function __construct(private Participant $participant)
	{
	}

	public function getLoginPage()
	{
		return view('admin.login');
	}

	public function postLogin(Request $req)
	{
		$credentials = $req->only('email', 'password');

		if (Auth::attempt($credentials))
			return redirect()->intended('/dashboard');

		return redirect()->back();
	}

	public function getDashboardPage()
	{
		$participants = $this->participant->orderBy('id')->get();

		return view('admin.dashboard', compact('participants'));
	}

	public function getLogoutUser()
	{
		Auth::logout();

		return redirect()->route('index.table');
	}

	public function getParticipantEditPage($id)
	{
		if ($participant = $this->participant->find($id))
			return view('participant.edit', compact('participant'));

		return redirect()->route('admin.dashboard');
	}
}

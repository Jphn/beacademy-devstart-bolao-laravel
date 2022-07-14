<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
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
		$participants = Participant::all();

		return view('admin.dashboard', compact('participants'));
	}

	public function getLogoutUser()
	{
		Auth::logout();

		return redirect()->route('index.table');
	}

	public function getParticipantEditPage($id)
	{
		if ($participant = Participant::find($id))
			return view('participant.edit', compact('participant'));

		return redirect()->route('admin.dashboard');
	}
}

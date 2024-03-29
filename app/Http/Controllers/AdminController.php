<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
	public function __construct(private Participant $participant, private User $user)
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
			return redirect()->intended(route('admin.dashboard'), 302);

		return redirect()->back(303);
	}

	public function getDashboardPage(Request $req)
	{
		$search = $req->search ?? null;

		$participants = $this->participant->getParticipants($search);

		return view('admin.dashboard', compact('participants', 'search'));
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

	public function getAdminDashboardPage()
	{
		$users = $this->user->all();

		return view('admin.list', compact('users'));
	}


	public function getUserEditPage($id)
	{
		$user = $this->user->findOrFail($id);

		return view('admin.edit', compact('user'));
	}
}

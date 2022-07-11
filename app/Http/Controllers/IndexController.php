<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;

class IndexController extends Controller
{
    public function getTablePage()
    {
        $participants = Participant::orderByDesc('points')->where('active', true)->get();

        return view('table', compact('participants'));
    }
}

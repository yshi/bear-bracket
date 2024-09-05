<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Tournament;
use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    public function index(Tournament $tournament)
    {
        return view('overall-scoreboard', [
            'tournament' => $tournament,
        ]);
    }

    public function show(Tournament $tournament, Division $division)
    {
        return view('division-scoreboard', [
            'tournament' => $tournament,
        ]);
    }
}

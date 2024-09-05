<?php

namespace App\Http\Controllers;

use App\Actions\Tournament\GetTournamentRounds;
use App\Models\Tournament;

class BracketController extends Controller
{
    public function index(GetTournamentRounds $bearHierarchySvc, Tournament $tournament)
    {
        return view('bracket', [
            'tournament' => $bearHierarchySvc->forTournament($tournament),
        ]);
    }

    public function show(GetTournamentRounds $bearHierarchySvc, Tournament $tournament, int $bracketId)
    {
        //
    }
}

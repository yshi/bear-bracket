<?php

namespace App\Http\Controllers;

use App\Actions\Tournament\GetBracketData;
use App\Models\Tournament;
use Illuminate\Http\Request;

class BracketController extends Controller
{
    public function index(Request $request, GetBracketData $bearHierarchySvc, Tournament $tournament)
    {
        return view('bracket', [
            'bracket' => $bearHierarchySvc->forTournament($tournament, $request->user()),
        ]);
    }

    public function show(GetBracketData $bearHierarchySvc, Tournament $tournament, int $bracketId)
    {
        //
    }
}

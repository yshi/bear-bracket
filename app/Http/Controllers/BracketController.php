<?php

namespace App\Http\Controllers;

use App\Actions\Tournament\GetBracketData;
use App\Models\Tournament;
use Illuminate\Http\Request;

class BracketController extends Controller
{
    public function index(GetBracketData $bearHierarchySvc, Tournament $tournament)
    {
        return view('bracket', [
            'bracket' => $bearHierarchySvc->forTournament($tournament),
        ]);
    }

    public function edit(Request $request, GetBracketData $bearHierarchySvc, Tournament $tournament)
    {
        $userBracket = $tournament->user_brackets()->whereBelongsTo($request->user())->first();

        if (! $userBracket && ! $tournament->isOpenForPicks()) {
            return view('closed', [
                'tournament' => $tournament,
            ]);
        }

        if (! $userBracket) {
            $userBracket = $tournament->user_brackets()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        $uiBracket = $bearHierarchySvc->forUser($tournament, $request->user());

        // If you have a bracket: show it
        // If this tournament is open for picks, initialize one & show
        // Otherwise, show a "not open" screen

        return view('bracket', [
            'bracket' => $uiBracket,
        ]);
    }

    public function show(GetBracketData $bearHierarchySvc, Tournament $tournament, int $bracketId)
    {
        $userBracket = $tournament->user_brackets()->findOrFail($bracketId);
        $uiBracket = $bearHierarchySvc->forUser($tournament, $userBracket->user);

        return view('bracket', [
            'bracket' => $uiBracket,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Actions\Tournament\GetBracketData;
use App\Models\Tournament;
use App\Models\UserBracket;
use Illuminate\Http\Request;

class BracketController extends Controller
{
    public function index(GetBracketData $bearHierarchySvc, Tournament $tournament)
    {
        return view('bracket.show', [
            'bracket' => $bearHierarchySvc->forTournament($tournament),
        ]);
    }

    public function edit(Request $request, GetBracketData $bearHierarchySvc, Tournament $tournament)
    {
        $user = $request->user();

        $bracket = $tournament->user_brackets()->whereBelongsTo($user)->first();

        if (! $bracket) {
            $canCreateBracket = $user->can('create', UserBracket::class);;

            if (! $canCreateBracket) {
                return view('closed', [
                    'tournament' => $tournament,
                ]);
            }

            $bracket = $tournament->user_brackets()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        return view('bracket.show-mine', [
            'bracket' => $bracket,
        ]);
    }

    public function show(GetBracketData $bearHierarchySvc, Tournament $tournament, int $bracketId)
    {
        $bracket = $tournament->user_brackets()->findOrFail($bracketId);
        $uiBracket = $bearHierarchySvc->forUser($bracket);

        return view('bracket.show', [
            'bracket' => $uiBracket,
        ]);
    }
}

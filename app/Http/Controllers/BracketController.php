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
        return view('bracket', [
            'bracket' => $bearHierarchySvc->forTournament($tournament),
        ]);
    }

    public function edit(Request $request, GetBracketData $bearHierarchySvc, Tournament $tournament)
    {
        $user = $request->user();

        $userBracket = $tournament->user_brackets()->whereBelongsTo($user)->first();

        if (! $userBracket) {
            $canCreateBracket = $user->can('create', UserBracket::class);;

            if (! $canCreateBracket) {
                return view('closed', [
                    'tournament' => $tournament,
                ]);
            }

            $userBracket = $tournament->user_brackets()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        // @TODO: This probably needs to go into a Livewire component
        $uiBracket = $bearHierarchySvc->forUser($tournament, $request->user());

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

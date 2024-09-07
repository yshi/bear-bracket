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
        return view('bracket.index', [
            'bracket' => $bearHierarchySvc->forTournament($tournament),
        ]);
    }

    public function edit(Request $request, GetBracketData $bracketService, Tournament $tournament)
    {
        $user = $request->user();

        /** @var UserBracket $bracket */
        $bracket = $tournament->user_brackets()->whereBelongsTo($user)->first();

        if (! $bracket) {
            $canCreateBracket = $user->can('create', [UserBracket::class, $tournament]);

            if (! $canCreateBracket) {
                return view('bracket.registration-closed', [
                    'tournament' => $tournament,
                ]);
            }

            $bracket = $tournament->user_brackets()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        if (! $tournament->isOpenForPicks() && ! $bracket->completed_selections) {
            return view('bracket.registration-closed', [
                'tournament' => $tournament,
            ]);
        }

        return view('bracket.show-mine', [
            'bracket' => $bracket,
            'uiBracket' => $bracketService->forUser($bracket),
        ]);
    }

    public function show(GetBracketData $bracketService, Tournament $tournament, int $bracketId)
    {
        /** @var UserBracket $bracket */
        $bracket = $tournament->user_brackets()->findOrFail($bracketId);
        $uiBracket = $bracketService->forUser($bracket);

        abort_unless($bracket->completed_selections, 404, 'Bracket incomplete');

        return view('bracket.show', [
            'bracket' => $uiBracket,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Actions\Tournament\GetTournamentRounds;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request, GetTournamentRounds $bearHierarchySvc)
    {
        $tournament = Tournament::query()
            ->with([
                'matches.first_bear',
                'matches.second_bear',
            ])
            ->whereSlug('fat-bear-week-2023')
            ->first();

        $matchHierarchy = $bearHierarchySvc->forTournament($tournament);

        return view('dashboard', [
            'tournament' => $tournament,
            'rounds' => $matchHierarchy->rounds,
        ]);
    }
}

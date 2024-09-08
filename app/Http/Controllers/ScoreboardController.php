<?php

namespace App\Http\Controllers;

use App\Actions\Tournament\Leaderboard;
use App\Models\Division;
use App\Models\Tournament;
use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    public function index(Request $request, Leaderboard $leaderboardRepo, Tournament $tournament)
    {
        return view('scoreboard.index', [
            'tournament' => $tournament,
            'leaderboard' => $leaderboardRepo->overall($tournament)->paginate(100),
            'ranking' => $leaderboardRepo->overallRankFor($tournament, $request->user()),
        ]);
    }

    public function show(Request $request, Leaderboard $leaderboardRepo, Tournament $tournament, Division $division)
    {
        return view('scoreboard.show', [
            'tournament' => $tournament,
            'division' => $division,
            'leaderboard' => $leaderboardRepo->division($tournament, $division)->paginate(100),
            'ranking' => $leaderboardRepo->divisionRankFor($tournament, $division, $request->user()),
        ]);
    }
}

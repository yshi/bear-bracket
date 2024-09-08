<?php

declare(strict_types=1);

namespace App\Actions\Tournament;

use App\Models\Division;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Leaderboard
{
    public function overall(Tournament $tournament): Builder
    {
        return $tournament->user_brackets()
            ->select([
                'user_brackets.*',
                DB::raw('DENSE_RANK() OVER (ORDER BY score DESC) AS ranking'),
            ])
            ->where('completed_selections', true)
            ->with(['user.division'])
            ->orderBy('ranking')
            ->orderBy('id');
    }

    public function division(Tournament $tournament, Division $division): Builder
    {
        return $this->overall($tournament)
            ->whereRelation('user', 'division_id', $division->id);
    }

    public function overallRankFor(Tournament $tournament, User $user): ?int
    {
        return $this->rankFor($this->overall($tournament), $user);
    }

    public function divisionRankFor(Tournament $tournament, Division $division, User $user): ?int
    {
        return $this->rankFor($this->division($tournament, $division), $user);
    }

    protected function rankFor(Builder $query, User $user): ?int
    {
        return DB::query()
            ->fromSub($query, 'leaderboard')
            ->where('user_id', $user->id)
            ->value('ranking');
    }
}

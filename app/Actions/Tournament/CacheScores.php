<?php

declare(strict_types=1);

namespace App\Actions\Tournament;

use App\Actions\Tournament\Entity\RenderableBracket;
use App\Actions\Tournament\Entity\RenderableRound;
use App\Actions\Tournament\Scoring\ScoringTableInterface;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CacheScores
{
    public function __construct(
        protected GetBracketData $bracketService,
        protected ScoringTableInterface $scoringTable,
    ) {
        //
    }

    public function forTournament(Tournament $tournament): Tournament
    {
        $bracket = $this->bracketService->forTournament($tournament);

        $pointQuery = $this->subqueryForMatchPoints($bracket);
        $sumQuery = DB::query()
            ->select([
                'user_brackets.id AS user_bracket_id',
                DB::raw('SUM(tournament_match_point_values.point_value) AS total_score')
            ])
            ->from('user_brackets')
            ->join('user_bracket_matches', 'user_brackets.id', '=', 'user_bracket_matches.user_bracket_id')
            ->join('tournament_matches', 'user_bracket_matches.tournament_match_id', '=', 'tournament_matches.id')
            ->joinSub($pointQuery, 'tournament_match_point_values', 'tournament_matches.id', '=', 'tournament_match_point_values.tournament_match_id')
            ->where('user_brackets.tournament_id', $tournament->id)
            ->where('user_brackets.completed_selections', true)
            ->whereNotNull('tournament_matches.winning_bear_id')
            ->whereColumn('user_bracket_matches.selected_bear_id', '=', 'tournament_matches.winning_bear_id')
            ->groupBy('user_brackets.id');

        // Do the updates for everybody.
        DB::table('user_brackets')
            ->joinSub($sumQuery, 'user_bracket_calculated_scores', 'user_brackets.id', '=', 'user_bracket_calculated_scores.user_bracket_id')
            ->updateFrom([
                'user_brackets.score' => DB::raw('user_bracket_calculated_scores.total_score'),
            ]);

        return $tournament;
    }


    protected function subqueryForMatchPoints(RenderableBracket $tournament): Builder
    {
        $pointsPerMatch = $this->pointsPerMatch($tournament);

        $sql = [];
        $bindValues = [];
        foreach ($pointsPerMatch as $value) {
            $sql[] = '(?::int, ?::int)';
            $bindValues[] = $value['match']->id;
            $bindValues[] = $value['points'];
        }

        $sql = implode(', ', $sql);

        return DB::query()->fromRaw("(VALUES {$sql}) AS tournament_match_point_values (tournament_match_id, point_value)", $bindValues);
    }

    /**
     * @return array{match: TournamentMatch, points: int}[]
     */
    protected function pointsPerMatch(RenderableBracket $tournament): array
    {
        $pointTable = collect($this->scoringTable->table());
        $byRound = $this->matchesByRound($tournament->rounds);

        return $byRound->map(function (Collection $matches, int $round) use ($pointTable) {
            $pointValue = $pointTable->get($round);

            return $matches->map(function (TournamentMatch $match) use ($pointValue) {
                return [
                    'match' => $match,
                    'points' => $pointValue,
                ];
            });
        })->values()->flatten(depth: 1)->all();
    }

    /**
     * Round => list of {@see TournamentMatch::$id}s
     *
     * @param RenderableRound[] $rounds
     * @return Collection<int, Collection<TournamentMatch>> $matchLookup
     */
    protected function matchesByRound(array $rounds): Collection
    {
        $table = collect();

        foreach ($rounds as $round) {
            $roundTable = collect();

            foreach ($round->matches as $match) {
                $roundTable->add($match->match);
            }

            $table->put($round->sequence, $roundTable);
        }

        return $table;
    }
}

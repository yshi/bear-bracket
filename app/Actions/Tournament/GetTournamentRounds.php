<?php

declare(strict_types=1);

namespace App\Actions\Tournament;

use App\Actions\Tournament\Entity\Bye;
use App\Actions\Tournament\Entity\MatchData;
use App\Actions\Tournament\Entity\Round;
use App\Actions\Tournament\Entity\Pairing;
use App\Actions\Tournament\Entity\TournamentHierarchy;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetTournamentRounds
{
    public function forTournament(Tournament $tournament): TournamentHierarchy
    {
        $matches = $this->initialMatches($tournament);

        $roundCounter = 1;
        $rounds = collect([
            new Round(
                sequence: $roundCounter,
                matches: $matches->map(fn (TournamentMatch $m) => new MatchData($m, false, false))->all(),
            ),
        ]);

        while(true) {
            $roundCounter++;
            $matches = $this->roundMatches($tournament, $matches);

            if ($matches->count() == 0) {
                break;
            }

            $rounds[] = new Round(
                sequence: $roundCounter,
                matches: $matches->map(function (TournamentMatch $match) {
                    return new MatchData(
                        $match,
                        $match->first_prior_match->is_bye,
                        $match->second_prior_match->is_bye
                    );
                })->all(),
            );
        }

        return new TournamentHierarchy($rounds->all());
    }

    protected function initialMatches(Tournament $tournament): Collection
    {
        return $this->roundMatches($tournament, priorMatches: null);
    }

    protected function roundMatches(Tournament $tournament, ?Collection $priorMatches): Collection
    {
        $query = $tournament->matches()
            ->with([
                'first_prior_match',
                'first_bear',
                'second_prior_match',
                'second_bear',
                'winner',
            ])
            ->orderBy('sequence');

        if ($priorMatches) {
            $query = $query->where(function (Builder $query) use ($priorMatches) {
                $idList = $priorMatches->map->id->all();

                $query->whereIn('first_prior_tournament_match_id', $idList)
                    ->orWhereIn('second_prior_tournament_match_id', $idList);
            });
        } else {
            $query = $query->where(function (Builder $query)  {
                return $query->whereNull('first_prior_tournament_match_id')
                    ->whereNull('second_prior_tournament_match_id');
            });
        }

        return $query->get();
    }
}

<?php

declare(strict_types=1);

namespace App\Actions\Tournament;

use App\Actions\Tournament\Entity\Bye;
use App\Actions\Tournament\Entity\RenderableMatch;
use App\Actions\Tournament\Entity\RenderableRound;
use App\Actions\Tournament\Entity\Pairing;
use App\Actions\Tournament\Entity\RenderableBracket;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetBracketData
{
    public function forTournament(Tournament $tournament, User $user): RenderableBracket
    {
        $matches = $this->initialMatches($tournament);

        $roundCounter = 1;
        $rounds = collect([
            new RenderableRound(
                sequence: $roundCounter,
                matches: $matches->map(fn (TournamentMatch $m) => new RenderableMatch($m, false, false))->all(),
            ),
        ]);

        while(true) {
            $roundCounter++;
            $matches = $this->roundMatches($tournament, $matches);

            if ($matches->count() == 0) {
                break;
            }

            $rounds[] = new RenderableRound(
                sequence: $roundCounter,
                matches: $matches->map(function (TournamentMatch $match) {
                    return new RenderableMatch(
                        $match,
                        $match->first_prior_match->is_bye,
                        $match->second_prior_match->is_bye
                    );
                })->all(),
            );
        }

        return new RenderableBracket(
            user: $user,
            tournament: $tournament,
            rounds: $rounds->all()
        );
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

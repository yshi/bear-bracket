<?php

declare(strict_types=1);

namespace App\Actions\Tournament;

use App\Actions\Tournament\Entity\Bye;
use App\Actions\Tournament\Entity\RenderableMatch;
use App\Actions\Tournament\Entity\RenderableMatchPick;
use App\Actions\Tournament\Entity\RenderableMatchScore;
use App\Actions\Tournament\Entity\RenderablePickResult;
use App\Actions\Tournament\Entity\RenderableRound;
use App\Actions\Tournament\Entity\Pairing;
use App\Actions\Tournament\Entity\RenderableBracket;
use App\Actions\Tournament\Entity\RenderableUser;
use App\Actions\Tournament\Scoring\ScoringTableInterface;
use App\Models\Bear;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\User;
use App\Models\UserBracket;
use App\Models\UserBracketMatch;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetBracketData
{
    public function __construct(
        protected ScoringTableInterface $scoringTable,
    ) {
        //
    }

    /**
     * Gets the official results for the tournament
     */
    public function forTournament(Tournament $tournament): RenderableBracket
    {
        return new RenderableBracket(
            tournament: $tournament,
            rounds: $this->getRounds($tournament)->all(),
        );
    }

    /**
     * Gets a user's picks, with information about whether they were right
     */
    public function forUser(UserBracket $bracket): RenderableBracket
    {
        $bracket->loadMissing([
            'tournament.matches' => [
                'first_prior_match',
                'first_bear',
                'second_prior_match',
                'second_bear',
                'winner',
            ],
            'matches.selected_bear',
        ]);

        $rounds = $this->getRounds($bracket->tournament);

        /** @var Collection<int, Bear> $userPicks */
        $userPicks = $bracket->matches->mapWithKeys(function (UserBracketMatch $match) {
           return [$match->tournament_match_id => $match->selected_bear];
        });

        $totalMatches = 0;
        $totalPicks = 0;
        $totalScore = 0;

        $rounds = $rounds->map(function (RenderableRound $round) use ($userPicks, &$totalMatches, &$totalPicks, &$totalScore) {
            $matches = collect($round->matches)->map(function (RenderableMatch $match) use ($userPicks, $round, &$totalMatches, &$totalPicks, &$totalScore) {
                if ($match->match->is_bye) {
                    return $match;
                }

                $match->firstBear = $userPicks->get($match->match->first_prior_match?->id, $match->firstBear);
                $match->secondBear = $userPicks->get($match->match->second_prior_match?->id, $match->secondBear);
                $match->pickedBear = $userPicks->get($match->match?->id);

                if ($match->match->winner) {
                    $scored = $match->match->winner->is($match->pickedBear);
                    $points = $scored
                        ? $this->scoringTable->score($round->sequence)
                        : 0;

                    $totalScore += $points;

                    $match->score = new RenderableMatchScore(
                        scored: $scored,
                        pointsScored: $points,
                    );
                }

                $totalMatches += 1;
                if ($match->pickedBear) {
                    $totalPicks += 1;
                }

                return $match;
            });

            $round->matches = $matches->all();
            return $round;
        });

        return new RenderableBracket(
            tournament: $bracket->tournament,
            rounds: $rounds->all(),
            player: new RenderableUser(
                user: $bracket->user,
                remainingPredictions: $totalMatches - $totalPicks,
                totalScore: $totalScore,
                divisionRank: null,
                overallRank: null,
            )
        );
    }

    public function subsequentMatches(TournamentMatch $match): Collection
    {
        $allMatches = collect();

        $subsequentMatches = TournamentMatch::query()
            ->where(function (Builder $query) use ($match) {
                $query->whereBelongsTo($match, 'first_prior_match')
                    ->orWhereBelongsTo($match, 'second_prior_match');
            })
            ->get()
            ->collect()
            ->values();

        foreach ($subsequentMatches as $subsequentMatch) {
            $allMatches->add($subsequentMatch);
            $allMatches = $allMatches->concat($this->subsequentMatches($subsequentMatch)->all());
        }

        return $allMatches;
    }

    /**
     * @return Collection<RenderableRound>
     */
    protected function getRounds(Tournament $tournament): Collection
    {
        $matches = $this->initialMatches($tournament);

        $roundCounter = 1;
        $rounds = collect([
            new RenderableRound(
                sequence: $roundCounter,
                matches: $matches->map(fn (TournamentMatch $m) => new RenderableMatch($m, $m->first_bear, $m->second_bear, false, false))->all(),
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
                        $match->first_bear,
                        $match->second_bear,
                        $match->first_prior_match->is_bye,
                        $match->second_prior_match->is_bye,
                    );
                })->all(),
            );
        }

        return $rounds;
    }

    /**
     * @return Collection<TournamentMatch>
     */
    protected function initialMatches(Tournament $tournament): Collection
    {
        return $this->roundMatches($tournament, priorMatches: null);
    }

    /**
     * @param Collection<TournamentMatch>|null $priorMatches
     * @return Collection<TournamentMatch>
     */
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

<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Scoring;

interface ScoringTableInterface
{
    /**
     * Returns an array of round number => point values.
     *
     * @return array{int, int}
     */
    public function table(int $maxRound = 4): array;

    /**
     * Returns the point value for a round.
     *
     * @param int $round Round number.
     * @return int Point value.
     */
    public function score(int $round): int;
}

<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

readonly class Round
{
    /**
     * @param MatchData[] $matches
     */
    public function __construct(
        public int $sequence,
        public array $matches,
    )
    {
        //
    }
}

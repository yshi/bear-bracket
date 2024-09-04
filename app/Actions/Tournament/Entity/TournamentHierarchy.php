<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

readonly class TournamentHierarchy
{
    /**
     * @param Round[] $rounds
     */
    public function __construct(
        public array $rounds,
    )
    {
        //
    }
}

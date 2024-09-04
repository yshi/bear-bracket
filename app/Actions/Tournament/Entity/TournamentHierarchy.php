<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

use App\Models\Tournament;

readonly class TournamentHierarchy
{
    /**
     * @param Round[] $rounds
     */
    public function __construct(
        public Tournament $tournament,
        public array $rounds,
    )
    {
        //
    }
}

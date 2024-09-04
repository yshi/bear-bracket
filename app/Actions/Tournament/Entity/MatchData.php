<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

use App\Models\TournamentMatch;

readonly class MatchData
{
    public function __construct(
        public TournamentMatch $match,
        public bool $firstBearFromBye,
        public bool $secondBearFromBye,
    ) {
        //
    }
}

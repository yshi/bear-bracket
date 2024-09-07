<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

use App\Models\TournamentMatch;

class RenderableMatch
{
    public function __construct(
        readonly public TournamentMatch $match,
        readonly public bool $firstBearFromBye,
        readonly public bool $secondBearFromBye,
        public ?RenderableMatchPick $pick = null,
    ) {
        //
    }
}

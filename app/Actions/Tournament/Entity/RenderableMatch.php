<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

use App\Models\Bear;
use App\Models\TournamentMatch;

class RenderableMatch
{
    public function __construct(
        readonly public TournamentMatch $match,
        public ?Bear $firstBear,
        public ?Bear $secondBear,
        readonly public bool $firstBearFromBye,
        readonly public bool $secondBearFromBye,
        public ?Bear $pickedBear = null,
        public ?RenderableMatchScore $score = null,
    ) {
        //
    }

    public function hasResult(): bool
    {
        return $this->match->winner !== null;
    }

    public function winner(): ?Bear
    {
        return $this->match->winner;
    }
}

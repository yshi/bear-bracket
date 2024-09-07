<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\User;
use Illuminate\Support\Collection;

readonly class RenderableBracket
{
    /**
     * @param RenderableRound[] $rounds
     */
    public function __construct(
        public Tournament $tournament,
        public array $rounds,
        public ?RenderableUser $player = null,
    )
    {
        //
    }
}

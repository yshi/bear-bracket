<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

use App\Models\Tournament;
use App\Models\User;

readonly class RenderableBracket
{
    /**
     * @param RenderableRound[] $rounds
     */
    public function __construct(
        public Tournament $tournament,
        public array $rounds,
        public ?RenderableUser $user = null,
    )
    {
        //
    }
}

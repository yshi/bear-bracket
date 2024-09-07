<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

use App\Models\User;

readonly class RenderableUser
{
    public function __construct(
        public User $user,
        public ?int $totalScore,
        public ?int $divisionRank,
        public ?int $overallRank,
    ) {
        //
    }
}

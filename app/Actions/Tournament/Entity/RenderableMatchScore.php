<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

readonly class RenderableMatchScore
{
    public function __construct(
        public ?bool $scored,
        public ?int $pointsScored,
    ) {
        //
    }
}

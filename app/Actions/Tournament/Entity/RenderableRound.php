<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

readonly class RenderableRound
{
    /**
     * @param RenderableMatch[] $matches
     */
    public function __construct(
        public int $sequence,
        public array $matches,
    )
    {
        //
    }
}

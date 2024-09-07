<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

class RenderableRound
{
    /**
     * @param RenderableMatch[] $matches
     */
    public function __construct(
        readonly public int $sequence,
        public array $matches,
    )
    {
        //
    }
}

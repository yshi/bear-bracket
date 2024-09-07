<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

use App\Models\Bear;

readonly class RenderablePickResult
{
    public function __construct(
        public ?bool $scored,
        public ?int $pointsScored,
    ) {
        //
    }
}

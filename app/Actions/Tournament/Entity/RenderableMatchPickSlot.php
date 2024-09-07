<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

use App\Models\Bear;

readonly class RenderableMatchPickSlot
{
    public function __construct(
        public array $possibleBears,
        public ?Bear $pick = null,
    ) {
        //
    }
}

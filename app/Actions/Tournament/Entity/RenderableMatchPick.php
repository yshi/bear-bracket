<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Entity;

readonly class RenderableMatchPick
{
    public function __construct(
        public RenderableMatchPickSlot $firstBear,
        public RenderableMatchPickSlot $secondBear,
        public ?RenderablePickResult $result,
    ) {
        //
    }
}

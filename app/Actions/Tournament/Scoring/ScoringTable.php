<?php

declare(strict_types=1);

namespace App\Actions\Tournament\Scoring;

use Illuminate\Support\Arr;

class ScoringTable implements ScoringTableInterface
{
    public function table(int $maxRound = 4): array
    {
        if ($maxRound > 4) {
            throw new \InvalidArgumentException('Only supports 4 rounds');
        }

        return [
            1 => 1,
            2 => 2,
            3 => 4,
            4 => 8,
        ];
    }

    public function score(int $round): int
    {
        return Arr::get($this->table(), $round);
    }
}

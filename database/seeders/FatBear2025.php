<?php

namespace Database\Seeders;

use App\Models\Bear;
use App\Models\Tournament;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FatBear2025 extends Seeder
{
    public function run(): void
    {
        $tournament = $this->tournament();
        $bears = $this->bears();

        $matches = collect([
            // Sequence, Date, Bear A, Bear B, bye flag
            'tuesA' => [1, '2024-09-23', $bears['128-jr'], $bears['609'], false],
            'tuesByeA' => [2, '2024-09-23', $bears['602'], null, true],
            'tuesB' => [3, '2024-09-23', $bears['503'], $bears['901'], false],
            'tuesByeB' => [4, '2024-09-23', $bears['32-chunk'], null, true],

            'wedsA' => [5, '2024-09-24', $bears['26'], $bears['909'], false],
            'wedsByeA' => [6, '2024-09-24', $bears['128-grazer'], null, true],
            'wedsB' => [7, '2024-09-24', $bears['99'], $bears['856'], false],
            'wedsByeB' => [8, '2024-09-24', $bears['910'], null, true],

            'thursA' => [9, '2024-09-25', null, $bears['602'], false],
            'thursB' => [10, '2024-09-25', null, $bears['32-chunk'], false],

            'friA' => [11, '2024-09-26', null, $bears['128-grazer'], false],
            'friB' => [12, '2024-09-26', null, $bears['910'], false],

            'monA' => [13, '2024-09-29', null, null, false],
            'monB' => [14, '2024-09-29', null, null, false],

            'fbTues' => [15, '2023-09-30', null, null, false],
        ])->mapWithKeys(function (array $data, string $key) use ($tournament) {
            [$sequence, $matchDate, $firstBear, $secondBear, $byeFlag] = $data;

            $match = $tournament->matches()->create([
                'sequence' => $sequence,
                'is_bye' => $byeFlag,
                'match_date' => $matchDate,
                'first_bear_id' => $firstBear?->id,
                'second_bear_id' => $secondBear?->id,
                'winning_bear_id' => null,
            ]);

            return [$key => $match];
        });

        // Hierarchy
        collect([
            'thursA' => ['tuesA', 'tuesByeA'],
            'thursB' => ['tuesB', 'tuesByeB'],

            'friA' => ['wedsA', 'wedsByeA'],
            'friB' => ['wedsB', 'wedsByeB'],

            'monA' => ['thursA', 'thursB'],
            'monB' => ['friA', 'friB'],

            'fbTues' => ['monA', 'monB'],
        ])->each(function (array $priorMatches, string $currentMatch) use ($matches) {
            $matches[$currentMatch]->update([
                'first_prior_tournament_match_id' => $matches[$priorMatches[0]]->id,
                'second_prior_tournament_match_id' => $matches[$priorMatches[1]]->id,
            ]);
        });
    }

    private function tournament(): Tournament
    {
        return Tournament::firstOrCreate(['slug' => 'fat-bear-week-2025'], [
            'label' => 'Fat Bear Week 2025',
            'registration_opens_at' => '2025-09-22 00:00:00',
            'registration_closes_at' => '2025-09-24 16:00:00',
            'order_index' => 1,
        ]);
    }

    private function bears(): Collection
    {
        return collect([
            '128 Jr',
            '609',
            '602',
            '503',
            '901',
            '32 Chunk',
            '26',
            '909',
            '128 Grazer',
            '99',
            '856',
            '910'
        ])->mapWithKeys(function (string $name) {
            $slug = Str::slug($name);

            return [
                $slug => Bear::firstOrCreate(['slug' => $slug], ['name' => $name])
            ];
        });
    }
}

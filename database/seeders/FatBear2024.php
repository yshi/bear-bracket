<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Bear;
use App\Models\Tournament;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FatBear2024 extends Seeder
{
    public function run(): void
    {
        $tournament = $this->tournament();
        $bears = $this->bears();

        $matches = collect([
            // Sequence, Date, Bear A, Bear B, bye flag
            'wedA' => [1, '2024-10-02', $bears['909-jr'], $bears['519'], false],
            'wedByeA' => [2, '2024-10-02', $bears['128-grazer'], null, true],
            'wedB' => [3, '2024-10-02', $bears['903-gully'], $bears['909'], false],
            'wedByeB' => [4, '2024-10-02', $bears['747'], null, true],

            'thurA' => [5, '2024-10-03', $bears['856'], $bears['504'], false],
            'thurByeA' => [6, '2024-10-03', $bears['32-chunk'], null, true],
            'thurB' => [7, '2024-10-03', $bears['151-walker'], $bears['901'], false],
            'thurByeB' => [8, '2024-10-03', $bears['164-bucky'], null, true],

            'friA' => [9, '2024-10-04', null, $bears['128-grazer'], false],
            'friB' => [10, '2024-10-04', null, $bears['747'], false],

            'satA' => [11, '2024-10-05', null, $bears['32-chunk'], false],
            'satB' => [12, '2024-10-05', null, $bears['164-bucky'], false],

            'monA' => [13, '2024-10-07', null, null, false],
            'monB' => [14, '2024-10-07', null, null, false],

            'fbTues' => [15, '2023-10-08', null, null, false],
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
            'friA' => ['wedA', 'wedByeA'],
            'friB' => ['wedB', 'wedByeB'],

            'satA' => ['thurA', 'thurByeA'],
            'satB' => ['thurB', 'thurByeB'],

            'monA' => ['friA', 'friB'],
            'monB' => ['satA', 'satB'],

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
        return Tournament::firstOrCreate(['slug' => 'fat-bear-week-2024'], [
            'label' => 'Fat Bear Week 2024',
            'registration_opens_at' => '2024-10-02 01:15:00',
            'registration_closes_at' => '2024-10-02 16:00:00',
            'order_index' => 1,
        ]);
    }

    private function bears(): Collection
    {
        return collect([
            '909 Jr',
            '519',
            '128 Grazer',
            '903 Gully',
            '909',
            '747',
            '856',
            '504',
            '32 Chunk',
            '151 Walker',
            '901',
            '164 Bucky',
        ])->mapWithKeys(function (string $name) {
            $slug = Str::slug($name);

            return [
                $slug => Bear::firstOrCreate(['slug' => $slug], ['name' => $name])
            ];
        });
    }
}

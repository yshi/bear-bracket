<?php

namespace Database\Seeders;

use App\Models\Bear;
use App\Models\Tournament;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FatBearJr2024 extends Seeder
{
    public function run(): void
    {
        throw new \Exception('TODO: Finalize me before running!');

        $tournament = $this->tournament();
        $bears = $this->bears();

        // @TODO: Dates are right, but this is NOT FINAL -- I just threw the bears in so I could validate the hierarchy!
        $matches = collect([
            // Date, Bear A, Bear B, bye flag
            'thursA' => [1, '2024-09-26', $bears['806-spring-cub'], $bears['901-spring-cub'], false],
            'thursB' => [2, '2024-09-26', $bears['909-junior'], $bears['910-yearling'], false],

            'fri' => [3, '2024-09-27', null, null, false],
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
            'fri' => ['thursA', 'thursB'],
        ])->each(function (array $priorMatches, string $currentMatch) use ($matches) {
            $matches[$currentMatch]->update([
                'first_prior_tournament_match_id' => $matches[$priorMatches[0]]->id,
                'second_prior_tournament_match_id' => $matches[$priorMatches[1]]->id,
            ]);
        });
    }

    private function tournament(): Tournament
    {
        return Tournament::firstOrCreate(['slug' => 'fat-bear-jr-2024'], [
            'label' => 'Fat Bear Week Jr 2024',
            'registration_opens_at' => '2024-09-25 01:00:00',
            'registration_closes_at' => '2024-09-26 16:00:00',
            'order_index' => 1,
        ]);
    }

    private function bears(): Collection
    {
        // @TODO: Not final, these are the 2023 cubs!
        return collect([
            '806 Spring Cub',
            '901 Spring Cub',
            '909 Junior',
            '910 Yearling',
        ])->mapWithKeys(function (string $name) {
            $slug = Str::slug($name);

            return [
                $slug => Bear::firstOrCreate(['slug' => $slug], ['name' => $name])
            ];
        });
    }
}

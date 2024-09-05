<?php

namespace Database\Seeders;

use App\Models\Bear;
use App\Models\Division;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentMatchProgression;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $division = Division::create([
            'slug' => 'demo',
            'invite_code' => 'demo',
            'name' => 'The Demonstrators',
        ]);

        User::factory()->create([
            'name' => 'owls',
            'email' => 'nick@godless-internets.org',
            'division_id' => $division->id,
        ]);

        $this->fatBear2023();
    }

    private function fatBear2023(): Tournament
    {
        $tournament = Tournament::create([
            'label' => 'Fat Bear Week 2023',
            'slug' => 'fat-bear-week-2023',
            'registration_opens_at' => Carbon::now()->subWeek(),
            'registration_closes_at' => Carbon::now()->addWeek(),
        ]);

        $bears = collect([
            '806 Jr',
            '428',
            '402',
            '901',
            '128',
            '151',
            '284',
            '164',
            '32',
            '480',
            '747',
            '435',
        ])->mapWithKeys(fn (string $name) => [$name => Bear::factory()->createOne(['name' => $name])]);

        $matches = collect([
            // Date, Bear A, Bear B, winning bear
            'wedA' => [1, '2023-10-04', $bears['806 Jr'], $bears['428'], $bears['806 Jr']],
            'wedByeA' => [2, '2023-10-04', $bears['32'], null, null],
            'wedB' => [3, '2023-10-04', $bears['402'], $bears['901'], $bears['901']],
            'wedByeB' => [4, '2023-10-04', $bears['480'], null, null],

            'thurA' => [5, '2023-10-05', $bears['128'], $bears['151'], $bears['128']],
            'thurByeA' => [6, '2023-10-05', $bears['747'], null, null],
            'thurB' => [7, '2023-10-05', $bears['284'], $bears['164'], $bears['164']],
            'thurByeB' => [8, '2023-10-05', $bears['435'], null, null],

            'friA' => [9, '2023-10-06', $bears['806 Jr'], $bears['32'], $bears['32']],
            'friB' => [10, '2023-10-06', $bears['480'], $bears['901'], $bears['901']],

            'satA' => [11, '2023-10-07', $bears['747'], $bears['128'], $bears['128']],
            'satB' => [12, '2023-10-07', $bears['164'], $bears['435'], $bears['435']],

            'monA' => [13, '2023-10-09', $bears['32'], $bears['901'], $bears['32']],
            'monB' => [14, '2023-10-09', $bears['128'], $bears['435'], $bears['128']],

            'fbTues' => [15, '2023-10-10', $bears['32'], $bears['128'], $bears['128']],
        ])->mapWithKeys(function (array $data, string $key) use ($tournament) {
            [$sequence, $matchDate, $firstBear, $secondBear, $winningBear] = $data;

            $match = $tournament->matches()->create([
                'sequence' => $sequence,
                'is_bye' => ! ($firstBear && $secondBear),
                'match_date' => $matchDate,
                'first_bear_id' => $firstBear?->id,
                'second_bear_id' => $secondBear?->id,
                'winning_bear_id' => $winningBear?->id,
            ]);

            return [$key => $match];
        });

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

        return $tournament;
    }
}

@php
/** @var \App\Actions\Tournament\Entity\TournamentHierarchy $tournament */
@endphp
<div class="grid grid-cols-1 lg:grid-cols-2 pb-8 border-b-2">
    <div class="text-white">
        <h2 class="text-4xl mb-4">todo username's bracket</h2>
        <p>Don't forget to vote daily &mdash; <em>in both matchups!</em> &mdash; at <a class="underline" target="_blank" href="https://fatbearweek.org">FatBearWeek.org</a>.</p>
    </div>

    <div class="flex flex-row justify-end gap-8 text-white">
        <div class="w-32 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
            <div class="text-4xl">100</div>
            <span class="text-gray-300">Total Score</span>
        </div>

        <div class="w-32 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
            <div class="text-4xl">1</div>
            <span class="text-gray-300">Division Rank</span>
        </div>

        <div class="w-32 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
            <div class="text-4xl">23</div>
            <span class="text-gray-300">Overall Rank</span>
        </div>
    </div>
</div>
<div class="flex mr-3 mt-8">
    @foreach ($tournament->rounds as $round)
        <ol class="flex flex-1 flex-col justify-around mr-5 round @unless($loop->first) ml-5 @endunless" id="round-{{ $round->sequence }}">
            @foreach ($round->matches as $matchData)
                @unless ($matchData->match->is_bye)
                    @php
                    $isWinner = function (?\App\Models\Bear $bear) use ($matchData): ?bool {
                        if (! $matchData->match->winner) {
                            return null;
                        }

                        return $matchData->match->winner->is($bear);
                    };

                    $firstBearWon = $isWinner($matchData->match->first_bear);
                    $secondBearWon = $isWinner($matchData->match->second_bear);
                    @endphp

                    <x-tournament.pairing-slot :bear="$matchData->match->first_bear" :fromBye="$matchData->firstBearFromBye" :winner="$firstBearWon"/>
                    <x-tournament.pairing-slot :bear="$matchData->match->second_bear" :fromBye="$matchData->secondBearFromBye" :winner="$secondBearWon"/>
                @else
                    <x-tournament.pairing-slot :bear="$matchData->match->first_bear" :fromBye="$matchData->firstBearFromBye" :isBye="true"/>
                    <x-tournament.pairing-slot :bear="$matchData->match->first_bear" /> {{-- hidden by the CSS --}}
                @endif
            @endforeach
        </ol>
    @endforeach
</div>

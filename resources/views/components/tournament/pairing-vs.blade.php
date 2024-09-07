@props(['matchData'])
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

<x-tournament.pairing-slot :bear="$matchData->match->first_bear"
                           :fromBye="$matchData->firstBearFromBye" :winner="$firstBearWon"/>
<x-tournament.pairing-slot :bear="$matchData->match->second_bear"
                           :fromBye="$matchData->secondBearFromBye" :winner="$secondBearWon"/>

@props(['matchData'])
@php
    $isWinner = function (?\App\Models\Bear $bear) use ($matchData): ?bool {
        if (! $matchData->match->winner) {
            return null;
        }

        return $matchData->match->winner->is($bear);
    };

    $firstBearWon = $isWinner($matchData->firstBear);
    $secondBearWon = $isWinner($matchData->secondBear);

    $firstBearClick = '';
    $secondBearClick = '';

    $readyForPick = $matchData->firstBear && $matchData->secondBear;
    if ($readyForPick) {
        $firstBearClick = "\$wire.pickWinner({$matchData->match->id}, {$matchData->firstBear->id})";
        $secondBearClick = "\$wire.pickWinner({$matchData->match->id}, {$matchData->secondBear->id})";
    }
@endphp

<x-tournament.pairing-slot :bear="$matchData->firstBear"
                           :fromBye="$matchData->firstBearFromBye"
                           :winner="$firstBearWon"
                           x-on:click="{{ $firstBearClick }}"
/>
<x-tournament.pairing-slot :bear="$matchData->secondBear"
                           :fromBye="$matchData->secondBearFromBye"
                           :winner="$secondBearWon"
                           x-on:click="{{ $secondBearClick }}"
/>

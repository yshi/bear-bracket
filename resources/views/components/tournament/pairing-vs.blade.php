@props([
    'matchData',
    'canPick' => false,
])
@php
    use App\Models\Bear;

    /** @var \App\Actions\Tournament\Entity\RenderableMatch $matchData */

    $isWinner = function (?Bear $bear) use ($matchData): ?bool {
        if (! $matchData->match->winner) {
            return null;
        }

        return $matchData->match->winner->is($bear);
    };

    $isPick = function (?Bear $slotBear, ?Bear $pickedBear): ?bool {
        if ($slotBear === null || $pickedBear === null) {
            return null;
        }

        return $pickedBear->is($slotBear);
    };

    $firstBearWon = $isWinner($matchData->firstBear);
    $firstBearPicked = $isPick($matchData->firstBear, $matchData->pickedBear);

    $secondBearWon = $isWinner($matchData->secondBear);
    $secondBearPicked = $isPick($matchData->secondBear, $matchData->pickedBear);

    $firstBearClick = '';
    $secondBearClick = '';

    $readyForPick = $matchData->firstBear && $matchData->secondBear;
    if ($readyForPick && $canPick) {
        $firstBearClick = "\$wire.pickWinner({$matchData->match->id}, {$matchData->firstBear->id})";
        $secondBearClick = "\$wire.pickWinner({$matchData->match->id}, {$matchData->secondBear->id})";
    }
@endphp

<x-tournament.pairing-slot :bear="$matchData->firstBear"
                           :fromBye="$matchData->firstBearFromBye"
                           :winner="$firstBearWon"
                           :pick="$firstBearPicked"
                           :$readyForPick
                           :$canPick
                           @click="{{ $firstBearClick }}"
                           @keyup.enter="{{ $firstBearClick }}"
/>
<x-tournament.pairing-slot :bear="$matchData->secondBear"
                           :fromBye="$matchData->secondBearFromBye"
                           :winner="$secondBearWon"
                           :pick="$secondBearPicked"
                           :$readyForPick
                           :$canPick
                           @click="{{ $secondBearClick }}"
                           @keyup.enter="{{ $secondBearClick }}"
/>

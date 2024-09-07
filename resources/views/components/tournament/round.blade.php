@props([
    'round',
    'canPick' => false,
])
<ol {{ $attributes->merge(['class' => 'flex flex-1 flex-col justify-around mr-5 round']) }} id="round-{{ $round->sequence }}">
    @foreach ($round->matches as $matchData)
        @unless ($matchData->match->is_bye)
            <x-tournament.pairing-vs :$matchData :$canPick />
        @else
            <x-tournament.pairing-bye :$matchData />
        @endif
    @endforeach
</ol>

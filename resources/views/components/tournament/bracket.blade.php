<div class="flex mr-3 mt-16">
    @foreach ($rounds as $round)
        <ol class="flex flex-1 flex-col justify-around mr-5 round @unless($loop->first) ml-5 @endunless" id="round-{{ $round->sequence }}">
            @foreach ($round->matches as $matchData)
                @unless ($matchData->match->is_bye)
                    <x-tournament.pairing-slot :bear="$matchData->match->first_bear" :fromBye="$matchData->firstBearFromBye"/>
                    <x-tournament.pairing-slot :bear="$matchData->match->second_bear" :fromBye="$matchData->secondBearFromBye"/>
                @else
                    <x-tournament.pairing-slot :bear="$matchData->match->first_bear" :fromBye="$matchData->firstBearFromBye" :isBye="true"/>
                    <x-tournament.pairing-slot :bear="$matchData->match->first_bear" /> {{-- hidden by the CSS --}}
                @endif
            @endforeach
        </ol>
    @endforeach
</div>

@props(['matchData'])
<x-tournament.pairing-slot :bear="$matchData->match->first_bear"
                           :fromBye="$matchData->firstBearFromBye" :isBye="true"/>
<x-tournament.pairing-slot :bear="$matchData->match->first_bear"/> {{-- hidden by the CSS --}}

@props(['matchData'])
<x-tournament.pairing-slot :bear="$matchData->firstBear"
                           :fromBye="$matchData->firstBearFromBye" :isBye="true"/>
<x-tournament.pairing-slot :bear="$matchData->firstBear"/> {{-- hidden by the CSS --}}

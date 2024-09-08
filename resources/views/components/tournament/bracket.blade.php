@props([
    'bracket',
    'canPick' => false,
])
@php
    /** @var \App\Actions\Tournament\Entity\RenderableBracket $bracket */
@endphp
<div class="grid grid-cols-1 lg:grid-cols-2 pb-8 border-b-2">
    {{ $header }}
</div>
<div class="flex mr-3 mt-8 overflow-x-auto">
    @foreach ($bracket->rounds as $round)
        <x-tournament.round :$round :class="$loop->first ? '' : 'ml-5'" :$canPick />
    @endforeach
</div>

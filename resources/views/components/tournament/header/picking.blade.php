@props(['bracket'])
@php
    /** @var \App\Actions\Tournament\Entity\RenderableBracket $bracket */
@endphp
<div class="text-gray-600 dark:text-gray-400">
    <div class="flex flex-row gap-4">
        <div class="shrink-0">
            <img class="h-10 w-10 rounded-full object-cover" src="{{ $bracket->player->user->profile_photo_url }}" alt="" />
        </div>
        <h2 class="text-4xl mb-4">{{ $bracket->player->user->name }}</h2>
    </div>
    <p>Check out the bears on <a href="https://fatbearweek.org" class="underline">FatBearWeek.org</a> and make your predictions.</p>
</div>

<x-tournament.stat.deck>
    <x-tournament.stat.card>
        @if ($bracket->player->remainingPredictions > 0)
            {{ $bracket->player->remainingPredictions }}
        @else
            <span class="font-extrabold">Ready!</span>
        @endif

        <x-slot:label>
            Remaining Picks
        </x-slot:label>
    </x-tournament.stat.card>

    <x-tournament.stat.card>
        <time datetime="{{ $bracket->tournament->registration_closes_at->toIso8601String() }}">
            {{ now()->diffForHumans($bracket->tournament->registration_closes_at, \Carbon\CarbonInterface::DIFF_ABSOLUTE, true) }}
        </time>

        <x-slot:label>
            Countdown
        </x-slot:label>
    </x-tournament.stat.card>
</x-tournament.stat.deck>

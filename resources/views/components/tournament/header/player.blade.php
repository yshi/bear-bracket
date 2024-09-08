@props(['player'])
@php
/** @var \App\Actions\Tournament\Entity\RenderableUser $player */
@endphp
<div class="text-gray-600 dark:text-gray-400">
    <div class="flex flex-row gap-4">
        <div class="shrink-0">
            <img class="h-10 w-10 rounded-full object-cover" src="{{ $player->user->profile_photo_url }}" alt="" />
        </div>
        <h2 class="text-4xl mb-4">{{ $player->user->name }}</h2>
    </div>
    <p>Don't forget to vote daily &mdash; <em>in both matchups!</em> &mdash; at <a class="underline" target="_blank" href="https://fatbearweek.org">FatBearWeek.org</a>.</p>
</div>

<x-tournament.stat.deck>
    <x-tournament.stat.card>
        @if ($player->totalScore !== null)
            {{ $player->totalScore }}
        @else
            &ndash;
        @endif

        <x-slot:label>
            Total Score
        </x-slot:label>
    </x-tournament.stat.card>

    <x-tournament.stat.card>
        @if ($player->divisionRank !== null)
            {{ $player->divisionRank }}
        @else
            &ndash;
        @endif

        <x-slot:label>
            Division Rank
        </x-slot:label>
    </x-tournament.stat.card>

    <x-tournament.stat.card>
        @if ($player->overallRank !== null)
            {{ $player->overallRank }}
        @else
            &ndash;
        @endif

        <x-slot:label>
            Overall Rank
        </x-slot:label>
    </x-tournament.stat.card>
</x-tournament.stat.deck>

@props(['player'])
@php
/** @var \App\Actions\Tournament\Entity\RenderableUser $player */
@endphp
<div class="text-white">
    <div class="flex flex-row gap-4">
        <div class="shrink-0">
            <img class="h-10 w-10 rounded-full object-cover" src="{{ $player->user->profile_photo_url }}" alt="" />
        </div>
        <h2 class="text-4xl mb-4">{{ $player->user->name }}</h2>
    </div>
    <p>Don't forget to vote daily &mdash; <em>in both matchups!</em> &mdash; at <a class="underline" target="_blank" href="https://fatbearweek.org">FatBearWeek.org</a>.</p>
</div>

<div class="flex flex-row justify-end gap-8 text-white">
    <div class="w-32 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
        <div class="text-4xl">
            @if ($player->totalScore !== null)
                {{ $player->totalScore }}
            @else
                &ndash;
            @endif
        </div>
        <span class="text-gray-300">Total Score</span>
    </div>

    <div class="w-32 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
        <div class="text-4xl">
            @if ($player->divisionRank !== null)
                {{ $player->divisionRank }}
            @else
                &ndash;
            @endif
        </div>
        <span class="text-gray-300">Division Rank</span>
    </div>

    <div class="w-32 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
        <div class="text-4xl">
            @if ($player->overallRank !== null)
                {{ $player->overallRank }}
            @else
                &ndash;
            @endif
        </div>
        <span class="text-gray-300">Overall Rank</span>
    </div>
</div>

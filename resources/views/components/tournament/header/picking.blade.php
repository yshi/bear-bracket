@props(['bracket'])
@php
    /** @var \App\Actions\Tournament\Entity\RenderableBracket $bracket */
@endphp
<div class="text-white">
    <div class="flex flex-row gap-4">
        <div class="shrink-0">
            <img class="h-10 w-10 rounded-full object-cover" src="{{ $bracket->player->user->profile_photo_url }}" alt="" />
        </div>
        <h2 class="text-4xl mb-4">{{ $bracket->player->user->name }}</h2>
    </div>
    <p>Check out the bears on <a href="https://fatbearweek.org" class="underline">FatBearWeek.org</a> and make your predictions.</p>
</div>

<div class="flex flex-row justify-end gap-8 text-white">
    <div class="w-40 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
        <div class="text-4xl flex justify-end">
            @if ($bracket->player->remainingPredictions > 0)
                {{ $bracket->player->remainingPredictions }}
            @else
                <span class="font-extrabold">Ready!</span>
            @endif
        </div>
        <span class="text-gray-300">
            Remaining Picks
        </span>
    </div>

    <div class="w-40 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
        <div class="text-4xl">
            <time datetime="{{ $bracket->tournament->registration_closes_at->toIso8601String() }}">
                {{ now()->diffForHumans($bracket->tournament->registration_closes_at, \Carbon\CarbonInterface::DIFF_ABSOLUTE, true) }}
            </time>
        </div>
        <span class="text-gray-300">Countdown</span>
    </div>
</div>

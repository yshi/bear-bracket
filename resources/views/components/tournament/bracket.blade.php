@props([
    'bracket',
    'canPick' => false,
])
@php
    /** @var \App\Actions\Tournament\Entity\RenderableBracket $bracket */
@endphp
<div class="grid grid-cols-1 lg:grid-cols-2 pb-8 border-b-2">
    <div class="text-white">
        <div class="flex flex-row gap-4">
            @if ($bracket->player)
                <div class="shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $bracket->player->user->profile_photo_url }}" alt="" />
                </div>
                <h2 class="text-4xl mb-4">{{ $bracket->player->user->name }}</h2>
            @else
                <h2 class="text-4xl mb-4">Results</h2>
            @endif
        </div>
        <p>Don't forget to vote daily &mdash; <em>in both matchups!</em> &mdash; at <a class="underline" target="_blank"
                                                                                       href="https://fatbearweek.org">FatBearWeek.org</a>.
        </p>
    </div>

    @if ($bracket->player)
        <div class="flex flex-row justify-end gap-8 text-white">
            <div class="w-32 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
                <div class="text-4xl">
                    @if ($bracket->player->totalScore !== null)
                        {{ $bracket->player->totalScore }}
                    @else
                        &ndash;
                    @endif
                </div>
                <span class="text-gray-300">Total Score</span>
            </div>

            <div class="w-32 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
                <div class="text-4xl">
                @if ($bracket->player->divisionRank !== null)
                    {{ $bracket->player->divisionRank }}
                @else
                    &ndash;
                @endif
                </div>
                <span class="text-gray-300">Division Rank</span>
            </div>

            <div class="w-32 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
                <div class="text-4xl">
                @if ($bracket->player->overallRank !== null)
                    {{ $bracket->player->overallRank }}
                @else
                    &ndash;
                @endif
                </div>
                <span class="text-gray-300">Overall Rank</span>
            </div>
        </div>
    @endif
</div>
<div class="flex mr-3 mt-8">
    @foreach ($bracket->rounds as $round)
        <x-tournament.round :$round :class="$loop->first ? '' : 'ml-5'" :$canPick />
    @endforeach
</div>

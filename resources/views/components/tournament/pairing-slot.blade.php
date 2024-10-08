@props([
    'bear',
    'fromBye' => false,
    'isBye' => false,
    'winner' => null,
    'pick' => null,
    'canPick' => false,
    'readyForPick' => false,
    'score' => null,
])
@php
    $showPickHighlight = $canPick && $readyForPick && $pick === null;

    $liClasses = [
        'flex',
        'items-center',
        'm-2',
        'p-1',
        'leading-relaxed',
        'text-gray-700' => $winner === null,
        'bg-gray-300' => $winner === null,
        'dark:bg-gray-600' => $winner === null,
        'dark:text-gray-300' => $winner === null,
        'rounded-full',
        'relative',
        'with-connector',
        'transition',
        'ease-in-out',
        'from-bye' => $fromBye,
        'with-bye' => $isBye,
        'text-gray-300' => $winner !== null,
        'bg-green-900' => $winner === true,
        'bg-red-900' => $winner === false,
        'ring-2 ring-amber-500' => $showPickHighlight,
        'cursor-pointer' => $canPick && $bear,
        'hover:brightness-125' => $canPick && $bear,
    ];
@endphp
<li {{ $attributes->class($liClasses) }} {{ $attributes }} @if($canPick && $bear) tabindex="1" @endif>
    <span class="w-6 h-6 ml-1 mr-3 bg-gray-100 dark:bg-gray-300 rounded-full flex justify-center items-center">
        @if($canPick)
            @if ($bear)
                @if ($pick === true)
                    <x-icon.picked class="w-3 h-3 fill-green-800"/>
                @elseif ($pick === false)
                    <x-icon.not-picked class="w-3 h-3 fill-red-800"/>
                @else
                    @if ($readyForPick)
                        <x-icon.unlocked class="w-3 h-3 fill-amber-600"/>
                    @else
                        <x-icon.locked class="w-3 h-3 fill-gray-700"/>
                    @endif
                @endif
            @else
                <x-icon.locked class="w-3 h-3 fill-gray-700"/>
            @endif
        @else
            @if ($pick === true)
                <x-icon.picked class="w-3 h-3 fill-green-800"/>
            @elseif ($pick === false)
                <x-icon.not-picked class="w-3 h-3 fill-red-800"/>
            @endif
        @endif
    </span>
    <div class="text-nowrap min-w-28 w-full pr-4 mr-4 lg:mr-0 flex justify-between">
        @if ($bear)
            {{ $bear->name }}

            @if ($winner === true && $score)
                <span>+{{ $score->pointsScored }}</span>
            @endif
        @else
            <small class="italic">pending results!</small>
        @endif
    </div>

    @if ($winner === true)
        <span class="sr-only">Won</span>
    @elseif($winner === false)
        <span class="sr-only">Lost</span>
    @endif
</li>

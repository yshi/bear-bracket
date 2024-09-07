@props([
    'bear',
    'fromBye' => false,
    'isBye' => false,
    'winner' => null,
    'pick' => null,
    'readyForPick' => false,
])
@php
$showPickGlow = $readyForPick && $pick === null;
@endphp
<li
    class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector @if ($fromBye) from-bye @endif @if ($isBye) with-bye @endif @if ($winner === true) bg-green-900 @elseif ($winner === false) bg-red-900 @endif @if($showPickGlow) ring-2 ring-amber-500 @endif"
    {{ $attributes }}
>
    <span class="w-6 h-6 ml-1 mr-3 bg-gray-300 rounded-full flex justify-center items-center">
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
    </span>
    @if ($bear)
        {{ $bear->name }}
    @else
        <small class="italic">pending results!</small>
    @endif

    @if ($winner === true)
        <span class="sr-only">Won</span>
    @elseif($winner === false)
        <span class="sr-only">Lost</span>
    @endif
</li>

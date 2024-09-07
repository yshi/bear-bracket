@props([
    'bear',
    'fromBye' => false,
    'isBye' => false,
    'winner' => null,
    'pick' => null,
])
<li
    class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector @if ($fromBye) from-bye @endif @if ($isBye) with-bye @endif @if ($winner === true) bg-green-900 @elseif ($winner === false) bg-red-900 @endif"
    {{ $attributes }}
>
    <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
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

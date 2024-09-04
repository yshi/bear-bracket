@props([
    'bear',
    'fromBye' => false,
    'isBye' => false,
    'winner',
    'pick',
])
<li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector @if ($fromBye) from-bye @endif @if ($isBye) with-bye @endif">
    <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
    @if ($bear)
        {{ $bear->name }}
    @else
        <small class="italic">not known yet!</small>
    @endif
</li>

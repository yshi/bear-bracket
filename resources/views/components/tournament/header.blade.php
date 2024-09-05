@props(['tournament'])
<div class="flex flex-row gap-8">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $tournament->label }}
    </h2>

    <x-nav-link href="{{ route('tournament', $tournament->slug) }}" :active="request()->routeIs('tournament', $tournament->slug)">My Bracket</x-nav-link>
    <x-nav-link href="{{ route('scoreboard.division', [$tournament->slug, auth()->user()->division]) }}" :active="request()->routeIs('scoreboard.division')">Division Scoreboard</x-nav-link>
    <x-nav-link href="{{ route('scoreboard.overall', $tournament->slug) }}" :active="request()->routeIs('scoreboard.overall')">Global Scoreboard</x-nav-link>
</div>

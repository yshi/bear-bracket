<x-app-layout>
    <x-slot name="header">
        <x-tournament.header :$tournament/>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 p-6 lg:p-8 dark:text-white">
                    <div class="max-w-2xl mx-auto text-center">
                        <h2 class="text-4xl mb-4">Picking has Ended</h2>
                        <p class="mb-4">Voting for {{ $tournament->label }} is under way. It is too late to pick your bears.</p>
                        <p class="mb-4">
                            You can still check out
                            <a class="underline" href="{{ route('scoreboard.division', [$tournament, auth()->user()->division]) }}">
                                {{ auth()->user()->division->name }} Scoreboard
                            </a>
                            and see how your friends are doing!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

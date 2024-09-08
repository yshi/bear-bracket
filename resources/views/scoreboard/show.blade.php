<x-app-layout>
    <x-slot name="header">
        <x-tournament.header :$tournament/>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 p-6 lg:p-8">

                    <div class="grid grid-cols-1 lg:grid-cols-2 pb-8 border-b-2 mb-8">
                        <div class="text-gray-600 dark:text-gray-400">
                            <div class="flex flex-row gap-4">
                                <h2 class="text-4xl mb-4">{{ $division->name }} Scoreboard</h2>
                            </div>
                            <p>See how you're doing compared to your friends.</p>
                        </div>

                        <x-tournament.stat.deck>
                            <x-tournament.stat.card>
                                @unless ($ranking === null)
                                    {{ $ranking }}
                                @else
                                    &ndash;
                                @endunless

                                <x-slot:label>
                                    Your Rank
                                </x-slot:label>
                            </x-tournament.stat.card>
                        </x-tournament.stat.deck>
                    </div>

                    @include('scoreboard._table')

                    <div class="mt-4">
                        {{ $leaderboard->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
                        <div class="text-white">
                            <div class="flex flex-row gap-4">
                                <div class="shrink-0">
                                    <h2 class="text-4xl mb-4">{{ $division->name }} Leaderboard</h2>
                                </div>
                            </div>
                            <p>See how you're doing compared to your friends.</p>
                        </div>

                        <div class="flex flex-row justify-end gap-8 text-white">
                            <div class="w-40 text-right bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
                                <div class="text-4xl flex justify-end">
                                    @unless ($ranking === null)
                                        {{ $ranking }}
                                    @else
                                        &ndash;
                                    @endunless
                                </div>
                                <span class="text-gray-300">
                                    Your Rank
                                </span>
                            </div>
                        </div>
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

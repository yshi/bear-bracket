<x-app-layout>
    <x-slot name="header">
        <x-tournament.header :tournament="$bracket->tournament"/>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 p-6 lg:p-8">
                    <x-tournament.bracket :$bracket>
                        <x-slot:header>
                            <x-tournament.header.player :player="$bracket->player"/>
                        </x-slot:header>
                    </x-tournament.bracket>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

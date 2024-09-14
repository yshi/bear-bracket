@php /** @var \App\Models\Tournament $tournament */ @endphp
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
                        <h2 class="text-4xl mb-4">Check Back Soon!</h2>
                        <p class="mb-4">The bracket for {{ $tournament->label }} isn't ready.</p>
                        <p class="mb-4">
                            Check back at
                            <time
                                class="underline decoration-dotted"
                                title="Local time"
                                x-data="{ date: new Date($el.getAttribute('datetime')) }"
                                x-text="date.toLocaleString()"
                                datetime="{{ $tournament->registration_opens_at->toIso8601String() }}"
                            >
                                {{ $tournament->registration_opens_at->toDayDateTimeString() }}
                            </time>
                            to pick your bears!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

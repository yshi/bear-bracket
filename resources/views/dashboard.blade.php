@php
    /** @var \App\Actions\Tournament\Entity\MatchData[] $rounds */
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 p-6 lg:p-8">
                    <!-- Bracket -->
                    <div class="flex mr-3 mt-16">
                        @foreach ($rounds as $round)
                            <ol class="flex flex-1 flex-col justify-around mr-5 round @unless($loop->first) ml-5 @endunless" id="round-{{ $round->sequence }}">
                                @foreach ($round->matches as $matchData)
                                    @unless ($matchData->match->is_bye)
                                        <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector @if ($matchData->firstBearFromBye) from-bye @endif">
                                            <span
                                                class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                            {{ $matchData->match->first_bear->name }}
                                        </li>

                                        <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector @if ($matchData->secondBearFromBye) from-bye @endif">
                                            <span
                                                class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                            {{ $matchData->match->second_bear->name }}
                                        </li>
                                    @else
                                        <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector with-bye">
                                            <span
                                                class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                            {{ $matchData->match->first_bear->name }}
                                        </li>

                                        <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                            <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                            n/a
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        @endforeach

                        {{--
                        <ol class="flex flex-1 flex-col justify-around mr-5 round">
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector with-bye">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                        </ol>
                        <ol class="flex flex-1 flex-col justify-around mr-5 ml-5 round">
                            <li id="round-2" class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative from-bye with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                        </ol>
                        <ol class="flex flex-1 flex-col justify-around mr-5 ml-5 round">
                            <li id="round-3" class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                        </ol>
                        <ol class="flex flex-1 flex-col justify-around mr-5 ml-5 round">
                            <li id="round-4" class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                            <li class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                        </ol>
                        <ol class="flex flex-1 flex-col justify-around mr-5 ml-5 round round-winner">
                            <li id="round-5" class="flex items-center m-2 p-1 leading-relaxed bg-gray-600 text-gray-300 rounded-full relative with-connector">
                                <span class="w-6 h-6 ml-1 mr-1 inline-block bg-gray-300 rounded-full"></span>
                                Competitor
                            </li>
                        </ol>
                        --}}
                    </div>
                    <!-- End Bracket -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

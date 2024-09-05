@php
    /** @var \App\Actions\Tournament\Entity\MatchData[] $rounds */
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Help') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 prose dark:prose-invert mx-auto">
                    <h2>What is this?</h2>
                    <p>This is a Fat Bear Week bracket site, hosting both the Junior pre-tournament for the cubs, and the main event.</p>
                    <p>If you don't know what Fat Bear Week is: Katmai National Park in Alaska runs an online tournament where people vote for the fattest bears, right before they go into hibernation.</p>
                    <p>Check out <a href="https://fatbearweek.org">FatBearWeek.org</a> for more information.</p>

                    <h2>How do I use this?</h2>
                    <p>Prior to voting opening, you should make your picks. You may make changes up until voting begins.</p>
                    <p>Once voting is open, your choices are locked in, and no more users can participate.</p>

                    <h2>What is a division?</h2>
                    <p>It's a group of people who probably know each other. It's more fun to compete against your friends to see who can pick the fattest bears.</p>

                    <h2>How do points work?</h2>
                    <p>This works like March Madness: correct picks net you points based on what round the match was in. Correct picks later in the tournament are worth more points.</p>

                    <div class="w-1/2">
                        <table>
                            <thead>
                            <tr>
                                <th scope="col">Round</th>
                                <th scope="col">Points</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>8</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <p>I have no idea if this scoring system works for a small tournament.</p>

                    <h2>Is this open source?</h2>
                    <p>Yes, check out <a href="https://github.com/yshi/bear-brackets" target="_blank"><code>yshi/bear-brackets</code></a> on github.</p>

                    <h2>I have another problem!</h2>
                    <p>You should speak with <a href="https://godless-internets.org/contact" target="_blank">the administrator</a>.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

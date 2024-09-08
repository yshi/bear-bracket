@php
    /** @var \App\Actions\Tournament\Entity\RenderableMatch[] $rounds */
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
                    <h2 id="what-is-fat-bear-madness">What is Fat Bear Madness?</h2>
                    <p>This is a Fat Bear Week bracket challenge, hosting both the Junior pre-tournament for the cubs, and
                        the main event.</p>
                    <p>It works like the March Madness bracket challenge: before the event begins, you try to predict which bears will win. If you're right, you get points!</p>
                    <p>If you don't know what Fat Bear Week is: Katmai National Park in Alaska runs an online tournament
                        where people vote for the fattest bears, right before they go into hibernation.</p>
                    <p>Check out <a href="https://fatbearweek.org">FatBearWeek.org</a> for more information.</p>

                    <h2 id="how-do-i-use-this">How do I use this?</h2>
                    <p>Prior to voting opening, you should make your picks. You may make changes up until voting
                        begins.</p>
                    <p>Your bracket will indicate how many outstanding picks are left. You can continue to adjust your picks right up until Fat Bear voting begins. There's a countdown on your bracket indicating how long you have until your picks are locked in.</p>
                    <p>Once you get the 'ready' status, you're all set. Check back when match results are in and see if you scored!</p>
                    <p>Once voting is open, your choices are locked in, and no more users can participate.</p>
                    <p>You should upload an avatar in <a href="{{ route('profile.show') }}">your profile</a> (and set up 2FA!) while you wait for the fat bear-ing to start. It'll make you more distinct on the scoreboard.</p>

                    <h2 id="what-is-a-division">What is a division?</h2>
                    <p>It's a group of people who probably know each other. It's more fun to compete against your
                        friends.</p>
                    <p>You can see other divisions' scoreboards and the global scoreboard, if you're very competitive.</p>

                    <h2 id="how-do-points-work">How do points work?</h2>
                    <p>This works like March Madness: correct picks net you points based on what round the match was in.
                        Correct picks later in the tournament are worth more points.</p>

                    <div class="w-full md:w-1/2">
                        <table>
                            <thead>
                            <tr>
                                <th scope="col">Round</th>
                                <th scope="col">Points</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(app(\App\Actions\Tournament\Scoring\ScoringTableInterface::class)->table() as $round => $points)
                            <tr>
                                <td>{{ $round }}</td>
                                <td>{{ $points }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <p>I am not sure how well this works for a small tournament. We'll see!</p>

                    <h2 id="is-this-open-source">Is this open source?</h2>
                    <p>Sort of. The software is developed by <a href="https://yshi.org" class="underline">Yasashii Heavy Industries</a> and published on GitHub at <a href="https://github.com/yshi/bear-bracket" target="_blank"><code>yshi/bear-bracket</code></a>.</p>
                    <p>Feel free to run your own instance of Fat Bear Madness.</p>

                    <h2 id="i-have-another-problem">I have another problem!</h2>
                    <p>You should speak with <a href="https://godless-internets.org/contact" target="_blank">the
                            administrator</a>.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="p-4 w-10">
                <span class="sr-only">Avatar</span>
            </th>
            <th scope="col" class="p-4">Player</th>
            <th scope="col" class="p-4">Division</th>
            <th scope="col" class="p-4 text-right">Score</th>
            <th scope="col" class="p-4 text-right">Rank</th>
        </tr>
        </thead>
        <tbody>
        @php /** @var \App\Models\UserBracket $row */ @endphp
        @foreach($leaderboard as $row)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-3 py-4">
                    <img
                        src="{{ $row->user->profile_photo_url }}"
                        alt=""
                        class="max-w-none object-cover object-center rounded-full ring-white dark:ring-gray-900"
                        style="height: 2rem; width: 2rem;">
                </td>
                <td class="px-3 py-4">
                    <a href="{{ route('bracket', [$tournament, $row]) }}" class="underline">{{ $row->user->name }}</a>
                </td>
                <td class="px-3 py-4">{{ $row->user->division->name }}</td>
                <td class="px-3 py-4 tabular-nums text-right">{{ $row->score }}</td>
                <td class="px-3 py-4 tabular-nums text-right">{{ $row->ranking }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

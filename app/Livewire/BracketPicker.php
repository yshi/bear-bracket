<?php

namespace App\Livewire;

use App\Actions\Tournament\GetBracketData;
use App\Models\Bear;
use App\Models\TournamentMatch;
use App\Models\UserBracket;
use App\Models\UserBracketMatch;
use Livewire\Component;

class BracketPicker extends Component
{
    public UserBracket $bracket;

    public function mount(UserBracket $bracket)
    {
        $this->bracket = $bracket;
    }

    public function render(GetBracketData $bracketService)
    {
        $uiBracket = $bracketService->forUser($this->bracket);

        return view('livewire.bracket-picker', [
            'uiBracket' => $uiBracket,
        ]);
    }

    public function pickWinner(GetBracketData $bracketService, int $matchId, int $bearId)
    {
        /** @var TournamentMatch $match */
        $match = $this->bracket->tournament->matches()->findOrFail($matchId);

        /** @var Bear $bear */
        $bear = Bear::findOrFail($bearId);

        // @TODO: Validate the bear is valid for the match based on prior picks ...

        /** @var UserBracketMatch $userPick */
        $userPick = $this->bracket->matches()->firstOrNew(['tournament_match_id' => $match->id]);

        if ($userPick->selected_bear?->is($bear)) {
            // They didn't change their pick, this is a no-op.
            return;
        }

        $userPick->selected_bear_id = $bear->id;
        $userPick->save();

        // These matches are downstream and will have a different bear in one slot.
        // Make the user re-do those picks, since their old pick might be for a bear that isn't in the match anymore.
        $resetMatches = $bracketService->subsequentMatches($match);
        $this->bracket->matches()->whereIn('tournament_match_id', $resetMatches->map->id)->delete();

        // If they finished all their selections, mark the bracket as complete.
        $bracketStats = $bracketService->forUser($this->bracket);

        $this->bracket->completed_selections = $bracketStats->player->remainingPredictions == 0;
        $this->bracket->save();
    }
}

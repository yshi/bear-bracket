<?php

namespace App\Livewire;

use App\Actions\Tournament\GetBracketData;
use App\Models\Bear;
use App\Models\UserBracket;
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
        $match = $this->bracket->tournament->matches()->findOrFail($matchId);
        $bear = Bear::findOrFail($bearId);

        // @TODO: Validate the bear is valid for the match based on prior picks ...

        $this->bracket->matches()->updateOrCreate(
            attributes: [
                'tournament_match_id' => $match->id,
            ],
            values: [
                'selected_bear_id' => $bear->id,
            ]
        );

        // @TODO: Unset future picks, if the bear is no longer valid
    }
}

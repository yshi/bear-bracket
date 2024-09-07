<?php

namespace App\Livewire;

use App\Actions\Tournament\GetBracketData;
use App\Models\UserBracket;
use Livewire\Component;

class BracketPicker extends Component
{
    public UserBracket $bracket;

    public function mount(UserBracket $bracket)
    {
        $bracket->loadMissing([
            'tournament.matches' => [
                'first_prior_match',
                'first_bear',
                'second_prior_match',
                'second_bear',
                'winner',
            ],
        ]);

        $this->bracket = $bracket;
    }

    public function render(GetBracketData $bearHierarchySvc)
    {
        $uiBracket = $bearHierarchySvc->forUser($this->bracket);

        return view('livewire.bracket-picker', [
            'uiBracket' => $uiBracket,
        ]);
    }
}

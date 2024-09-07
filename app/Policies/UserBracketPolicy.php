<?php

namespace App\Policies;

use App\Models\Tournament;
use App\Models\User;
use App\Models\UserBracket;

class UserBracketPolicy
{
    public function create(User $user, Tournament $tournament): bool
    {
        return $tournament->isOpenForPicks();
    }

    public function edit(User $user, UserBracket $bracket): bool
    {
        if (! $user->is($bracket->user)) {
            return false;
        }

        return $bracket->tournament->isOpenForPicks();
    }
}

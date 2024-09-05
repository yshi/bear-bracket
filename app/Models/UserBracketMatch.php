<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBracketMatch extends Model
{
    use HasFactory;

    public function bracket(): BelongsTo
    {
        return $this->belongsTo(UserBracket::class, 'user_bracket_id');
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(TournamentMatch::class, 'tournament_match_id');
    }

    public function selected_bear(): BelongsTo
    {
        return $this->belongsTo(Bear::class, 'selected_bear_id');
    }
}

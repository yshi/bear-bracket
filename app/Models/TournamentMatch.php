<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TournamentMatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'match_date' => 'date',
    ];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function first_prior_match(): BelongsTo
    {
        return $this->belongsTo(TournamentMatch::class, 'first_prior_tournament_match_id');
    }

    public function first_bear(): BelongsTo
    {
        return $this->belongsTo(Bear::class, 'first_bear_id');
    }

    public function second_prior_match(): BelongsTo
    {
        return $this->belongsTo(TournamentMatch::class, 'second_prior_tournament_match_id');
    }

    public function second_bear(): BelongsTo
    {
        return $this->belongsTo(Bear::class, 'second_bear_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(Bear::class, 'winning_bear_id');
    }
}

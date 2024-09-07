<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Tournament extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'registration_opens_at' => 'datetime',
        'registration_closes_at' => 'datetime',
    ];

    public function matches(): HasMany
    {
        return $this->hasMany(TournamentMatch::class);
    }

    public function user_brackets(): HasMany
    {
        return $this->hasMany(UserBracket::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereNot('archived')->orderBy('order_index');
    }

    public function isOpenForPicks(?CarbonInterface $now = null): bool
    {
        $now ??= Carbon::now();

        return $now->between($this->registration_opens_at, $this->registration_closes_at);
    }
}

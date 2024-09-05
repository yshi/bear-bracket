<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use HasFactory, SoftDeletes;

    public function matches(): HasMany
    {
        return $this->hasMany(TournamentMatch::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereNot('archived')->orderBy('order_index');
    }
}

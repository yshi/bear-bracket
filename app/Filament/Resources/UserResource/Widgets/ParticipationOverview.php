<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Tournament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ParticipationOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return Tournament::active()
            ->withCount([
                'user_brackets' => fn (Builder $query) => $query->where('completed_selections', true),
            ])
            ->get()
            ->map(fn (Tournament $tournament) => Stat::make($tournament->label, $tournament->user_brackets_count))
            ->all();
    }
}

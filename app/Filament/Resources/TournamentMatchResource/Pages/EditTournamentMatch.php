<?php

namespace App\Filament\Resources\TournamentMatchResource\Pages;

use App\Actions\Tournament\CacheScores;
use App\Filament\Resources\TournamentMatchResource;
use App\Models\TournamentMatch;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

/**
 * @property TournamentMatch $record
 */
class EditTournamentMatch extends EditRecord
{
    protected static string $resource = TournamentMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    /**
     * This will catch updates to winners, and keep the leaderboard accurate.
     */
    protected function afterSave(): void
    {
        $cacheSvc = app(CacheScores::class);

        $cacheSvc->forTournament($this->record->tournament);
    }
}

<?php

namespace App\Filament\Resources\BearResource\Pages;

use App\Filament\Resources\BearResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBear extends EditRecord
{
    protected static string $resource = BearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

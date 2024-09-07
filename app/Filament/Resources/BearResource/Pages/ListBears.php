<?php

namespace App\Filament\Resources\BearResource\Pages;

use App\Filament\Resources\BearResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBears extends ListRecords
{
    protected static string $resource = BearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\BusinessHighlights\Pages;

use App\Filament\Resources\BusinessHighlights\BusinessHighlightResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageBusinessHighlights extends ManageRecords
{
    protected static string $resource = BusinessHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

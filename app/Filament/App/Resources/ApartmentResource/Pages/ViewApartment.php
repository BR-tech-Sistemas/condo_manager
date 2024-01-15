<?php

namespace App\Filament\App\Resources\ApartmentResource\Pages;

use App\Filament\App\Resources\ApartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewApartment extends ViewRecord
{
    protected static string $resource = ApartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

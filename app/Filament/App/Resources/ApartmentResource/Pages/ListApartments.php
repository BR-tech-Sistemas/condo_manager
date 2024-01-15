<?php

namespace App\Filament\App\Resources\ApartmentResource\Pages;

use App\Filament\App\Resources\ApartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApartments extends ListRecords
{
    protected static string $resource = ApartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

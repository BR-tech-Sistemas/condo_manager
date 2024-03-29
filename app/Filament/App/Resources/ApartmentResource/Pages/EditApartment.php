<?php

namespace App\Filament\App\Resources\ApartmentResource\Pages;

use App\Filament\App\Resources\ApartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApartment extends EditRecord
{
    protected static string $resource = ApartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            /*Actions\ViewAction::make(),*/
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

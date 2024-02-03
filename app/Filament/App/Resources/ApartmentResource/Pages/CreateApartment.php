<?php

namespace App\Filament\App\Resources\ApartmentResource\Pages;

use App\Filament\App\Resources\ApartmentResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateApartment extends CreateRecord
{
    protected static string $resource = ApartmentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Function to handle the creation of a new record adding the Condo ID before save it.
     * @param array $data
     * @return Model
     */
    protected function handleRecordCreation(array $data): Model
    {
        $data['condo_id'] = Filament::getTenant()->id;
        return static::getModel()::create($data);
    }
}

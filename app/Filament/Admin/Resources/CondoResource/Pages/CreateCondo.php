<?php

namespace App\Filament\Admin\Resources\CondoResource\Pages;

use App\Filament\Admin\Resources\CondoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCondo extends CreateRecord
{
    protected static string $resource = CondoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace App\Filament\App\Resources\BlockResource\Pages;

use App\Filament\App\Resources\BlockResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlock extends CreateRecord
{
    protected static string $resource = BlockResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

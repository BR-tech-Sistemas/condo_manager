<?php

namespace App\Filament\App\Resources\CommonAreaResource\Pages;

use App\Filament\App\Resources\CommonAreaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCommonArea extends CreateRecord
{
    protected static string $resource = CommonAreaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

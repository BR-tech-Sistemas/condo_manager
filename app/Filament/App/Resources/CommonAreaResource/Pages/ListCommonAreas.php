<?php

namespace App\Filament\App\Resources\CommonAreaResource\Pages;

use App\Filament\App\Resources\CommonAreaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommonAreas extends ListRecords
{
    protected static string $resource = CommonAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

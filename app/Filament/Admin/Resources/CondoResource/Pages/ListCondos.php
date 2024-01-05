<?php

namespace App\Filament\Admin\Resources\CondoResource\Pages;

use App\Filament\Admin\Resources\CondoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCondos extends ListRecords
{
    protected static string $resource = CondoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

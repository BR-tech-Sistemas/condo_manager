<?php

namespace App\Filament\App\Resources\RuleResource\Pages;

use App\Filament\App\Resources\RuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRule extends ViewRecord
{
    protected static string $resource = RuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

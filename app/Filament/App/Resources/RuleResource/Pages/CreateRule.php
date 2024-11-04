<?php

namespace App\Filament\App\Resources\RuleResource\Pages;

use App\Filament\App\Resources\RuleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRule extends CreateRecord
{
    protected static string $resource = RuleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

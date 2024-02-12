<?php

namespace App\Filament\App\Resources\VisitorResource\Pages;

use App\Filament\App\Resources\VisitorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVisitor extends CreateRecord
{
    protected static string $resource = VisitorResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

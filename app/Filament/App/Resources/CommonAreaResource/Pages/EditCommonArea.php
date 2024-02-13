<?php

namespace App\Filament\App\Resources\CommonAreaResource\Pages;

use App\Filament\App\Resources\CommonAreaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommonArea extends EditRecord
{
    protected static string $resource = CommonAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

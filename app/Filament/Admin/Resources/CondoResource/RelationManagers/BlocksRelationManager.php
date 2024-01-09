<?php

namespace App\Filament\Admin\Resources\CondoResource\RelationManagers;

use App\Filament\App\Resources\BlockResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BlocksRelationManager extends RelationManager
{
    protected static string $relationship = 'blocks';
    protected static ?string $title = 'Blocos';
    protected static ?string $modelLabel = 'Bloco';
    protected static ?string $pluralModelLabel = 'Blocos';
    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return BlockResource::form($form);
    }

    public function table(Table $table): Table
    {

        return BlockResource::table($table)
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}

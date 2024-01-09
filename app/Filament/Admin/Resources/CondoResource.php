<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CondoResource\Pages;
use App\Filament\Admin\Resources\CondoResource\RelationManagers;
use App\Models\Condo;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CondoResource extends Resource
{
    protected static ?string $model = Condo::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $modelLabel = 'Condomínio';
    protected static ?string $pluralModelLabel = 'Condomínios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Nome'),
                        TextInput::make('cep')
                            ->label('CEP')
                            ->nullable(),
                        TextInput::make('address')
                            ->required()
                            ->label('Endereço'),
                        Select::make('type')
                            ->label('Tipo de condomínio')
                            ->required()
                            ->options([
                                'residential' => 'Residencial',
                                'commercial' => 'Comercial'
                            ])
                            ->native(false),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cep')
                    ->label('CEP')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Endereço')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo de Condomínio')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('blocks.title')
                    ->wrap()
                    ->label('Blocos')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BlocksRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCondos::route('/'),
            'create' => Pages\CreateCondo::route('/create'),
            'edit' => Pages\EditCondo::route('/{record}/edit'),
        ];
    }
}

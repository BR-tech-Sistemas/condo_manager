<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\BlockResource\Pages;
use App\Filament\App\Resources\BlockResource\RelationManagers;
use App\Models\Block;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlockResource extends Resource
{
    protected static ?string $model = Block::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $modelLabel = "Bloco";
    protected static ?string $pluralModelLabel = "Blocos";
    protected static ?string $navigationGroup = 'Infraestrutura';

    protected static ?string $tenantOwnershipRelationshipName = 'condo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Nome')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Nome do Bloco')
                                ->required()
                                ->maxLength(255),
                        ]),
                ])->from('md'),

                Forms\Components\Split::make([
                    Forms\Components\Section::make('Configurações do Bloco')
                        ->schema([
                            Forms\Components\Toggle::make('has_sub_manager')
                                ->label('Tem subsíndico')
                                ->default(false)
                                ->offIcon('heroicon-o-x-mark')
                                ->offColor('danger')
                                ->onIcon('heroicon-s-check')
                                ->required(),
                            Forms\Components\Toggle::make('has_apartments')
                                ->label('Tem apartamentos')
                                ->default(true)
                                ->offIcon('heroicon-o-x-mark')
                                ->offColor('danger')
                                ->onIcon('heroicon-o-check')
                                ->required(),
                            Forms\Components\Toggle::make('has_parking_lot')
                                ->label('Tem estacionamento')
                                ->default(true)
                                ->offIcon('heroicon-o-x-mark')
                                ->offColor('danger')
                                ->onIcon('heroicon-s-check')
                                ->required(),
                        ]),
                ])->from('md'),

                /*Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\KeyValue::make('infrastructure'),
                    ])*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('condo.name')
                    ->label('Condomínio')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Nome do bloco')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('apartments.title')
                    ->label('Apartamentos')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_sub_manager')
                    ->label('Tem subsíndico?')
                    ->alignCenter()
                    ->sortable()
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_apartments')
                    ->label('Tem apartamentos?')
                    ->alignCenter()
                    ->sortable()
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_parking_lot')
                    ->label('Tem estacionamento?')
                    ->alignCenter()
                    ->sortable()
                    ->boolean(),
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
            RelationManagers\ApartmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlocks::route('/'),
            'create' => Pages\CreateBlock::route('/create'),
            'edit' => Pages\EditBlock::route('/{record}/edit'),
        ];
    }
}

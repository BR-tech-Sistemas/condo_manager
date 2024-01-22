<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ApartmentResource\Pages;
use App\Filament\App\Resources\ApartmentResource\RelationManagers;
use App\Models\Apartment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ApartmentResource extends Resource
{
    protected static ?string $model = Apartment::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $modelLabel = "Apartamento";
    protected static ?string $pluralModelLabel = "Apartamentos";
    protected static ?string $navigationGroup = 'Infraestrutura';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('block_id')
                    ->relationship('block', 'title')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('for_rent')
                    ->required(),
                Forms\Components\Toggle::make('for_sale')
                    ->required(),
                Forms\Components\TextInput::make('parking_lots')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('block.title')
                    ->label('Nome do bloco')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Número')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('for_rent')
                    ->label('Para alugar?')
                    ->alignCenter()
                    ->sortable()
                    ->boolean(),
                Tables\Columns\IconColumn::make('for_sale')
                    ->label('À venda?')
                    ->alignCenter()
                    ->sortable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('parking_lots')
                    ->label('Vagas de Estacionamento')
                    ->alignCenter()
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('residents.user.name')
                    ->label('Moradores')
                    ->wrap()
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('for_rent')
                    ->label('Para alugar?')
                    ->placeholder('Todos Apartamentos')
                    ->trueLabel('Sim')
                    ->falseLabel('Não'),
                Tables\Filters\TernaryFilter::make('for_sale')
                    ->label('À venda?')
                    ->placeholder('Todos Apartamentos')
                    ->trueLabel('Sim')
                    ->falseLabel('Não'),
            ])
            ->deferFilters()
            ->filtersApplyAction(
                fn (Tables\Actions\Action $action) => $action->label('Aplicar filtros'),
            )
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApartments::route('/'),
            'create' => Pages\CreateApartment::route('/create'),
            'view' => Pages\ViewApartment::route('/{record}'),
            'edit' => Pages\EditApartment::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\App\Resources;

use App\Models\CommonArea;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommonAreaResource extends Resource
{
    protected static ?string $model = CommonArea::class;

    protected static ?string $slug = 'common-areas';
    protected static ?string $pluralModelLabel = "Áreas Comuns";
    protected static ?string $modelLabel = "Área Comum";
    protected static ?string $navigationGroup = 'Infraestrutura';
    protected static ?string $tenantOwnershipRelationshipName = 'condo';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações Básicas')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título/Nome')
                            ->required(),

                        Select::make('block_id')
                            ->label('Bloco')
                            ->relationship('block', 'title')
                            ->nullable(),

                        Grid::make()
                            ->columns(3)
                            ->schema([
                                ToggleButtons::make('rentable')
                                    ->label('Alugável?')
                                    ->default(true)
                                    ->boolean()
                                    ->inline()
                                    ->required(),

                                ToggleButtons::make('schedulable')
                                    ->label('Agendável?')
                                    ->default(true)
                                    ->boolean()
                                    ->inline()
                                    ->required(),

                                ToggleButtons::make('need_authorization')
                                    ->label('Necessita de autorização?')
                                    ->default(false)
                                    ->boolean()
                                    ->inline()
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título/Nome')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('block.title')
                    ->label('Bloco')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),

                IconColumn::make('rentable')
                    ->label('Alugável?')
                    ->alignCenter()
                    ->sortable()
                    ->boolean(),

                IconColumn::make('schedulable')
                    ->label('Agendável?')
                    ->alignCenter()
                    ->sortable()
                    ->boolean(),

                IconColumn::make('need_authorization')
                    ->label('Necessita de autorização?')
                    ->alignCenter()
                    ->sortable()
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => CommonAreaResource\Pages\ListCommonAreas::route('/'),
            'create' => CommonAreaResource\Pages\CreateCommonArea::route('/create'),
            'edit' => CommonAreaResource\Pages\EditCommonArea::route('/{record}/edit'),
        ];
    }
}

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
use Illuminate\Database\Eloquent\Builder;

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
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Informações Básicas')
                        ->collapsible()
                        ->description('informações básicas sobre o apartamento.')
                        ->icon('heroicon-s-building-office')
                        ->schema([
                            Forms\Components\Select::make('block_id')
                                ->label('Bloco')
                                ->relationship(
                                    'block',
                                    'title',
                                    function (Builder $query){
                                        $query->whereHas('condo', function ($query){
                                            return $query->whereIn('condo_id', auth()->user()->condos->pluck('id'));
                                        });
                                    }
                                )
                                ->native(false)
                                ->required(),
                            Forms\Components\TextInput::make('title')
                                ->label('Nº Apartamento')
                                ->required()
                                ->maxLength(255),
                        ]),
                ]),
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Informações Adicionais')
                        ->collapsible()
                        ->description('informações extras sobre o apartamento.')
                        ->icon('heroicon-o-cog')
                        ->columns()
                        ->schema([
                            Forms\Components\ToggleButtons::make('for_rent')
                                ->label('Para alugar?')
                                ->boolean()
                                ->inline()
                                ->required(),
                            Forms\Components\ToggleButtons::make('for_sale')
                                ->label('Para venda?')
                                ->boolean()
                                ->inline()
                                ->required(),
                            Forms\Components\TextInput::make('parking_lots')
                                ->columnSpanFull()
                                ->label('Vagas de garagem')
                                ->required()
                                ->numeric()
                                ->default(0),
                        ]),
                ]),
                Forms\Components\Section::make('Informações dos moradores')
                    ->collapsible()
                    ->description('Cadastro dos moradores desse apartamento. Nesse local é possível registrar os inquilinos e proprietários.')
                    ->icon('heroicon-o-users')
                    ->persistCollapsed()
                    ->schema([
                        Forms\Components\Repeater::make('residents')
                            ->label('')
                            ->addActionLabel('Adicionar morador')
                            ->columns(3)
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('Morador')
                                    ->native(false)
                                    ->relationship(
                                        'user',
                                        'name',
                                        function (Builder $query){
                                            $query->whereHas('condos', function ($query){
                                                return $query->whereIn('condo_id', auth()->user()->condos->pluck('id'));
                                            });
                                        }
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\ToggleButtons::make('is_owner')
                                    ->label('Proprietário?')
                                    ->boolean()
                                    ->inline()
                                    ->required(),
                                Forms\Components\ToggleButtons::make('is_tenant')
                                    ->label('Inquilino??')
                                    ->boolean()
                                    ->inline()
                                    ->required(),
                            ])
                            ->itemLabel(fn(): string => 'Informações do Morador'),
                    ]),
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
                Tables\Actions\ActionGroup::make([
                    /*Tables\Actions\ViewAction::make(),*/
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->tooltip('Ações')
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
            /*'view' => Pages\ViewApartment::route('/{record}'),*/
            'edit' => Pages\EditApartment::route('/{record}/edit'),
        ];
    }
}

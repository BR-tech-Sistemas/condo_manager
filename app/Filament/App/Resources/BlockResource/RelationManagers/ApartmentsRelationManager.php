<?php

namespace App\Filament\App\Resources\BlockResource\RelationManagers;

use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApartmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'apartments';
    protected static ?string $title = 'Apartamentos';
    protected static ?string $modelLabel = 'Apartamento';
    protected static ?string $pluralModelLabel = 'Apartamentos';
    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Informações do Apartamento')
                            ->icon('heroicon-o-building-storefront')
                            ->columns()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Número do Apartamento')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('parking_lots')
                                    ->label('Vagas de garagem')
                                    ->numeric()
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Situação do Apartamento')
                            ->icon('heroicon-o-swatch')
                            ->columns(4)
                            ->schema([
                                Forms\Components\Toggle::make('for_rent')
                                    ->label('Para alugar?')
                                    ->offIcon('heroicon-o-x-mark')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-s-check')
                                    ->inline(false)
                                    ->required(),
                                Forms\Components\Toggle::make('for_sale')
                                    ->label('À venda?')
                                    ->offIcon('heroicon-o-x-mark')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-o-check')
                                    ->inline(false)
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Moradores do Apartamento')
                            ->icon('heroicon-o-users')
                            ->schema([
                                Forms\Components\Repeater::make('residents')
                                    ->label('')
                                    ->addActionLabel('Adicionar morador')
                                    ->columns()
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\Select::make('user_id')
                                            ->columnSpanFull()
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
                                        Forms\Components\Toggle::make('is_owner')
                                            ->label('Proprietário?')
                                            ->offIcon('heroicon-o-x-mark')
                                            ->offColor('danger')
                                            ->onIcon('heroicon-s-check')
                                            ->inline(false)
                                            ->required(),
                                        Forms\Components\Toggle::make('is_tenant')
                                            ->label('Inquilino?')
                                            ->offIcon('heroicon-o-x-mark')
                                            ->offColor('danger')
                                            ->onIcon('heroicon-s-check')
                                            ->inline(false)
                                            ->required(),
                                    ])
                                    ->itemLabel(fn(): string => 'Informações do Morador'),
                            ]),
                    ]),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
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
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('residents.user.name')
                    ->label('Moradores')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

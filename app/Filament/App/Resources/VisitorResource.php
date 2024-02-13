<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\VisitorResource\Pages;
use App\Filament\App\Resources\VisitorResource\RelationManagers;
use App\Models\Visitor;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FontLib\Table\Type\name;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class VisitorResource extends Resource
{
    protected static ?string $model = Visitor::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $modelLabel = 'Visitante';
    protected static ?string $pluralModelLabel = 'Visitantes';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $tenantOwnershipRelationshipName = 'condo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Informações Básicas')
                        ->columns([
                            'default' => 1,
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 1,
                            'xl' => 2,
                        ])
                        ->collapsible()
                        ->description('informações básicas sobre o apartamento.')
                        ->icon('heroicon-s-building-office')
                        ->schema([
                            Forms\Components\Select::make('apartment_id')
                                ->label('Apartamento')
                                ->searchable()
                                ->preload()
                                ->relationship(
                                    name: 'apartment',
                                    titleAttribute: 'title',
                                    modifyQueryUsing: function (Builder $query) {
                                        if (! auth()->user()->hasAnyRole(['Síndico', 'Porteiro'])){
                                            $query
                                                ->where('condo_id', Filament::getTenant()->id)
                                                ->whereIn('id', auth()->user()->apartments->pluck('id'));
                                        }
                                    }
                                )
                                ->getOptionLabelFromRecordUsing(function (Model $record) {
                                    $record->load('block');
                                    return "Bloco {$record->block->title}: Apto {$record->title}";
                                })
                                ->required()
                                ->native(false),
                            Forms\Components\TextInput::make('name')
                                ->label('Nome')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('rg')
                                ->label('RG')
                                ->maxLength(255),
                            Document::make('cpf')
                                ->label('CPF')
                                ->validation(false)
                                ->cpf()
                                ->maxLength(14),
                            PhoneNumber::make('phone')
                                ->label('Telefone')
                                ->format('(99) 99999-9999')
                                ->required()
                                ->maxLength(15),
                            Forms\Components\TextInput::make('email')
                                ->label('E-mail')
                                ->email()
                                ->maxLength(255),
                        ]),
                ]),
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Datas')
                        ->collapsible()
                        ->description('informações Período de liberação do visitante.')
                        ->icon('heroicon-o-cog')
                        ->columns([
                            'default' => 1,
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 1,
                            'xl' => 2,
                        ])
                        ->schema([
                            Forms\Components\DateTimePicker::make('entry_date')
                                ->label('Data de Entrada')
                                ->after('now')
                                ->seconds(false)
                                ->displayFormat('d/m/Y H:i')
                                ->native(false)
                                ->required(),
                            Forms\Components\DateTimePicker::make('exit_date')
                                ->label('Data de Saída')
                                ->after('entry_date')
                                ->seconds(false)
                                ->displayFormat('d/m/Y H:i')
                                ->native(false)
                                ->required(),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('apartment.block.title')
                    ->alignCenter()
                    ->label('Bloco')
                    ->numeric(),
                Tables\Columns\TextColumn::make('apartment_id')
                    ->alignCenter()
                    ->label('Apartamento')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('entry_date')
                    ->label('Data de Entrada')
                    ->toggleable()
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('exit_date')
                    ->label('Data de Saída')
                    ->toggleable()
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rg')
                    ->label('RG')
                    ->visible(auth()->user()->hasAnyRole(['super-admin', 'admin', 'Síndico']))
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->visible(auth()->user()->hasAnyRole(['super-admin', 'admin', 'Síndico']))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->visible(auth()->user()->hasAnyRole(['super-admin', 'admin', 'Síndico']))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->visible(auth()->user()->hasAnyRole(['super-admin', 'admin', 'Síndico']))
                    ->searchable(),

            ])
            ->defaultSort('entry_date')
            ->filters([
                /*Tables\Filters\TrashedFilter::make(),*/
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('Registrar Entrada')
                        ->icon('heroicon-o-identification')
                        ->color('warning')
                        ->visible(auth()->user()->hasAnyRole(['Síndico', 'Porteiro'])),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListVisitors::route('/'),
            'create' => Pages\CreateVisitor::route('/create'),
            'edit' => Pages\EditVisitor::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

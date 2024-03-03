<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AnnouncementResource\Pages;
use App\Filament\App\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $modelLabel = "Anúncio";
    protected static ?string $pluralModelLabel = "Anúncios";
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $tenantOwnershipRelationshipName = 'condo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('Descrição')
                            ->required(),
                        Forms\Components\ToggleButtons::make('show_dashboard')
                            ->label('Exibir no Dashboard?')
                            ->default(false)
                            ->boolean()
                            ->inline()
                            ->required(),
                        Forms\Components\Select::make('priority')
                            ->label('Prioridade')
                            ->options([
                                'high' => 'Alta',
                                'medium' => 'Média',
                                'low' => 'Baixa',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('valid_until')
                            ->label('Válido até')
                            ->displayFormat('d/m/Y')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),
                Tables\Columns\IconColumn::make('show_dashboard')
                    ->boolean()
                    ->alignCenter()
                    ->label('Exibir no Dashboard?')
                    ->visible(auth()->user()->hasAnyRole(['super-admin', 'admin', 'Síndico']))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('priority')
                    ->label('Prioridade')
                    ->badge()
                    ->color(fn (Announcement $record) => match ($record->priority) {
                        'high' => 'error',
                        'medium' => 'warning',
                        'low' => 'success',
                    })
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_until')
                    ->date('d/m/Y')
                    ->label('Válido até')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAnnouncements::route('/'),
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

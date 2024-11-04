<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\RuleResource\Pages;
use App\Filament\App\Resources\RuleResource\RelationManagers;
use App\Models\Rule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RuleResource extends Resource
{
    protected static ?string $model = Rule::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $slug = 'rules';
    protected static ?string $pluralModelLabel = "Regras";
    protected static ?string $modelLabel = "Regra";

    protected static ?string $navigationGroup = 'Geral';
    protected static ?string $tenantOwnershipRelationshipName = 'condo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações Básicas')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título/Nome')
                            ->required(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Descrição'),
                        Forms\Components\FileUpload::make('file')
                            ->columnSpanFull()
                            ->helperText('Arquivo PDF com a(s) regra(s) do condomínio.')
                            ->label('Arquivo'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título/Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->html()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRules::route('/'),
            'create' => Pages\CreateRule::route('/create'),
            'view' => Pages\ViewRule::route('/{record}'),
            'edit' => Pages\EditRule::route('/{record}/edit'),
        ];
    }
}

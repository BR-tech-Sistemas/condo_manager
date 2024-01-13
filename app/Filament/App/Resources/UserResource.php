<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\UserResource\Pages;
use App\Filament\App\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';
    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $pluralModelLabel = 'Usuários';
    protected static ?string $navigationGroup = 'Configurações';
    protected static ?string $tenantRelationshipName = 'residents';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações Pessoais')
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'xl' => 3
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->label(
                                fn(string $operation): string => $operation === 'edit' ? 'Nova Senha' : 'Senha',
                            )
                            ->placeholder(
                                fn(string $operation): string => $operation === 'edit' ? 'Nova Senha' : 'Senha',
                            )
                            ->password()
                            ->dehydrateStateUsing(
                                static fn(null|string $state):
                                null|string => filled($state) ? Hash::make($state) : null
                            )
                            ->required(
                                fn(string $operation): bool => $operation === 'create'
                            )
                            ->dehydrated(
                                static fn(null|string $state):
                                bool => filled($state),
                            )
                            ->confirmed()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(
                                fn(string $operation): string => $operation === 'edit' ? 'Confirmar Nova Senha' : 'Confirmar Senha',
                            )
                            ->placeholder(
                                fn(string $operation): string => $operation === 'edit' ? 'Confirmar Nova Senha' : 'Confirmar Senha',
                            )
                            ->password()
                            ->maxLength(255)
                            ->required(
                                fn(string $operation): bool => $operation === 'create'
                            ),
                    ]),
                Forms\Components\Section::make('Perfil do usuário')
                    ->columns()
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->multiple()
                            ->preload()
                            ->relationship(
                                titleAttribute: 'name',
                                modifyQueryUsing: function (Builder $query) {
                                    if (!auth()->user()->hasAnyRole(['super-admin'])) {
                                        $query->where('name', "!=", 'super-admin');
                                    }
                                }
                            )
                            ->native(false)
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
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->visible(auth()->user()->hasAnyRole(['super-admin', 'Síndico']))
                    ->label('Email verificado')
                    ->dateTime('d/m/y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Perfil')
                    ->sortable()
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

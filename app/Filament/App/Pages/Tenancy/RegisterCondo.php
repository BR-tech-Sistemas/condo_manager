<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Models\Condo;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterCondo extends RegisterTenant
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getLabel(): string
    {
        return 'Registar condomínio';
    }

    public function form(Form $form): Form
    {
        return $form
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
            ]);
    }

    protected function handleRegistration(array $data): Condo
    {
        $condo = Condo::create($data);

        $condo->residents()->attach(auth()->user());

        return $condo;
    }
}

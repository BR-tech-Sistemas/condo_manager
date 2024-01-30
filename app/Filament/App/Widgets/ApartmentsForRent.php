<?php

namespace App\Filament\App\Widgets;

use App\Models\Apartment;
use App\Models\Condo;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ApartmentsForRent extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 1;
    protected static ?string $heading = 'Apartamentos para Alugar';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Condo::query()
                    ->whereIn('id', auth()->user()->condos->pluck('id'))
                    ->with('apartments', function ($q) {
                        $q->where('for_rent', true);
                    })
                    ->wherehas('apartments'),
            )
            ->columns([
                TextColumn::make('apartments.title')
                    ->alignCenter()
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->label('Apartamentos'),
            ]);
    }
}

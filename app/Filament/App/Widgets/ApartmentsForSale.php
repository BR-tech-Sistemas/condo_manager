<?php

namespace App\Filament\App\Widgets;

use App\Models\Apartment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ApartmentsForSale extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 1;
    protected static ?string $heading = 'Apartamentos para Vender';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Apartment::query()
                    ->with(['block', 'residents'])
                    ->where('for_sale', true)
            )
            ->columns([
                TextColumn::make('block.title')
                    ->alignCenter()
                    ->label('Bloco'),
                TextColumn::make('title')
                    ->alignCenter()
                    ->label('Apartamento'),
                TextColumn::make('parking_lots')
                    ->alignCenter()
                    ->label('Vagas de garagem'),
            ])
            ->paginated(false)
            ->emptyStateIcon('heroicon-o-home')
            ->emptyStateHeading('Nenhum apartamento para vender.');
    }
}

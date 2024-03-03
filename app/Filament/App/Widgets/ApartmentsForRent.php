<?php

namespace App\Filament\App\Widgets;

use App\Models\Apartment;
use App\Traits\VisibilityOfWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ApartmentsForRent extends BaseWidget
{
    use VisibilityOfWidget;

    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 1;
    protected static ?string $heading = 'Apartamentos para Alugar';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Apartment::query()
                    ->with(['block', 'residents'])
                    ->where('for_rent', true)
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
            ->emptyStateHeading('Nenhum apartamento para Alugar.');
    }

    /**
     * Set the roles allowed to view this widget.
     *
     * @return string[]
     */
    protected static function getRolesAllowed(): array
    {
        return ['Síndico', 'Porteiro'];
    }
}

<?php

namespace App\Filament\App\Widgets;

use App\Models\Block;
use App\Traits\VisibilityOfWidget;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatsApartmentsOverview extends BaseWidget
{
    use VisibilityOfWidget;
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $stats = $this->calculateStats();
        return [
            Stat::make('Total de Apartamentos', $stats['all']),
            Stat::make('Apartamentos à Venda', $stats['sale']),
            Stat::make('Apartamentos para Alugar', $stats['rent']),
        ];
    }

    /**
     * @return array
     */
    private function calculateStats(): array
    {
        $condo = Filament::getTenant()->load([
            'blocks' => fn($query) => $query
                ->withCount('apartments as total_apartments')
                ->withSum('apartments as apartments_for_rent', 'for_rent')
                ->withSum('apartments as apartments_for_sale', 'for_sale'),
        ]);

        return [
            'all' => $condo->blocks->sum('total_apartments'),
            'rent' => $condo->blocks->sum('apartments_for_rent'),
            'sale' => $condo->blocks->sum('apartments_for_sale'),
        ];
    }
}

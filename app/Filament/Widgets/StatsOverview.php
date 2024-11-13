<?php

namespace App\Filament\Widgets;

use App\Models\BookingTransaction;
use App\Models\CarService;
use App\Models\CarStore;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;
    protected function getStats(): array
    {
        $successfulTransactionsCount = BookingTransaction::where('is_paid', true)->count();
        $totalRevenue = BookingTransaction::where('is_paid', true)->sum('total_amount');
        $formattedRevenue = 'Rp ' . number_format($totalRevenue, 0, ',', '.');
        $totalStore = CarStore::count();
        $totalService = CarService::count();
        return [
            Stat::make('Total Service', $totalService),
            Stat::make('Total Store', $totalStore),
            Stat::make('Successful Transactions', $successfulTransactionsCount),
            Stat::make('Total Revenue', $formattedRevenue),
        ];
    }
}

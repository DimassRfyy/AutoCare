<?php

namespace App\Filament\Resources\BookingTransactionResource\Widgets;

use App\Models\BookingTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingTransactionStats extends BaseWidget
{
    protected function getStats(): array
    {
        $successfulTransactionsCount = BookingTransaction::where('is_paid', true)->count();

        $totalRevenue = BookingTransaction::where('is_paid', true)->sum('total_amount');
        $formattedRevenue = 'Rp ' . number_format($totalRevenue, 0, ',', '.');      

        $totalTransaction = BookingTransaction::count();

        return [
            Stat::make('Total Transaction', $totalTransaction),
           Stat::make('Successful Transactions', $successfulTransactionsCount),
           Stat::make('Total Revenue', $formattedRevenue),
        ];
    }
}

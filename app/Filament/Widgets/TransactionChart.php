<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\BookingTransaction;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Transaction';

    protected function getData(): array
    {
        // Assuming you have a BookingTransaction model and a created_at field
        $transactions = BookingTransaction::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('is_paid', true)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Initialize data array with 0 for each month
        $data = array_fill(1, 12, 0);

        // Fill the data array with actual transaction counts
        foreach ($transactions as $month => $count) {
            $data[$month - 1] = $count; // Adjusting month index to start from 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Booking Transactions',
                    'data' => array_values($data),
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

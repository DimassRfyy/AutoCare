<?php

namespace App\Filament\Widgets;

use App\Models\BookingTransaction;
use App\Models\CarService;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PopularServiceChart extends ChartWidget
{
    protected static ?string $heading = 'Popular Services';
    public function getDescription(): ?string
{
    return 'Most Ordered Service';
}
    protected static ?string $maxHeight = '430px';

    protected function getData(): array
    {
        // Fetch the most requested services and their counts
        $services = BookingTransaction::query()
            ->select('car_service_id', DB::raw('count(*) as total'))
            ->groupBy('car_service_id')
            ->orderByDesc('total')
            ->with('service_details') // Load related CarService data
            ->get();
    
        // Initialize arrays for labels, data, and background colors
        $labels = [];
        $data = [];
        $backgroundColors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', 
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
        ];
    
        foreach ($services as $index => $service) {
            if ($service->service_details && $service->service_details->name) {
                $labels[] = $service->service_details->name;
                $data[] = $service->total;
            }
        }
    
        return [
            'datasets' => [
                [
                    'label' => 'Most Requested Car Services',
                    'data' => $data,
                    'backgroundColor' => array_slice($backgroundColors, 0, count($data)),
                ],
            ],
            'labels' => $labels,
        ];
    }
    
    protected function getType(): string
    {
        return 'pie'; // Change to 'doughnut' or 'pie' as needed
    }
}

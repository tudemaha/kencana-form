<?php

namespace App\Filament\Widgets;

use App\Models\FormSubmission;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class SubmissionsTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Submission Trend (Last 7 Days)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $period = CarbonPeriod::create(now()->subDays(6), now());

        $submissions = FormSubmission::whereBetween('submitted_at', [
            now()->subDays(6)->startOfDay(),
            now()->endOfDay(),
        ])->get();

        $labels = [];
        $data = [];

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $labels[] = $date->format('M d');

            $count = $submissions->filter(function ($submission) use ($dateString) {
                return $submission->submitted_at?->format('Y-m-d') === $dateString;
            })->count();

            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Submissions',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(79, 70, 229, 0.2)', // Indigo 600 with opacity
                    'borderColor' => '#4f46e5',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

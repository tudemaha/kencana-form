<?php

namespace App\Filament\Widgets;

use App\Models\FormSubmission;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class SubmissionsTrendChart extends ChartWidget
{
    protected ?string $heading = 'Submission Trend (Last 7 Days)';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected ?string $maxHeight = '200px';

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
                return Carbon::parse($submission->submitted_at)->format('Y-m-d') === $dateString;
            })->count();

            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Submissions',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(177, 207, 111, 0.2)', // Pastel Green with opacity
                    'borderColor' => '#b1cf6f',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'min' => 0,
                ],
            ],
        ];
    }
}

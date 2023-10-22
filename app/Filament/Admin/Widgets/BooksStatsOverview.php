<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BooksStatsOverview extends BaseWidget
{
    protected function getBookCountBy($status)
    {
        return \App\Models\Book::where('status', $status)->count();
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Total Books', \App\Models\Book::count())
                ->color('success')
                ->chart([$this->getBookCountBy('available'), $this->getBookCountBy('not available'), $this->getBookCountBy('out of stock')]),
            Stat::make('Available', $this->getBookCountBy('available'))
                ->color('success'),
            Stat::make('Not Available', $this->getBookCountBy('not available'))
                ->color('info'),
            Stat::make('Out of Stock', $this->getBookCountBy('out of stock'))
                ->color('danger'),
        ];
    }
}

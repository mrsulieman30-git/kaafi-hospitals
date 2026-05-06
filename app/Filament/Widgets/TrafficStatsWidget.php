<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Models\BlogPost;

class TrafficStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $uniqueVisitors = DB::table('site_stats')->count();
        $totalPageViews = DB::table('site_stats')->sum('hits');
        $totalAdViews = BlogPost::where('type', 'ad')->sum('views');

        return [
            Stat::make('Unique Visitors', number_format($uniqueVisitors))
                ->description('Total unique devices')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Total Page Hits', number_format($totalPageViews))
                ->description('Including page refreshes')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('primary'),
            Stat::make('Total Ad Views', number_format($totalAdViews))
                ->description('Across all active offers')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning'),
        ];
    }
}

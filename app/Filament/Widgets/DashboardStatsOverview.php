<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        
        return [
            Stat::make('Total Appointments', Appointment::count())
                ->description('All-time booking requests')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]), // Decorative chart line

            Stat::make('Pending Appointments', $pendingAppointments)
                ->description('Awaiting reception confirmation')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingAppointments > 0 ? 'warning' : 'success'),

            Stat::make('Active Doctors', Doctor::where('is_active', true)->count())
                ->description('Specialists currently on roster')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Registered Users', User::count())
                ->description('Patients and staff accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}

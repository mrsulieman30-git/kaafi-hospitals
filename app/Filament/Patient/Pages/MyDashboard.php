<?php

namespace App\Filament\Patient\Pages;

use App\Models\Appointment;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class MyDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.patient.pages.my-dashboard';
    
    protected static ?string $title = 'My Health Portal';

    public function getViewData(): array
    {
        $user = Auth::user();

        // Get the single next upcoming appointment
        $upcoming = Appointment::with(['doctor', 'department'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->whereDate('appointment_date', '>=', today())
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->first();

        // Get historical appointments
        $history = Appointment::with(['doctor', 'department'])
            ->where('user_id', $user->id)
            ->where(function ($query) {
                $query->whereIn('status', ['completed', 'cancelled'])
                      ->orWhereDate('appointment_date', '<', today());
            })
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();

        return [
            'upcoming' => $upcoming,
            'history' => $history,
        ];
    }
}

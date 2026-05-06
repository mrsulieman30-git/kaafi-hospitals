<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeBannerWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome-banner';

    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 0; // Forces this to be at the very top

    public function getViewData(): array
    {
        return [
            'user' => Auth::user(),
            'greeting' => $this->getGreeting(),
        ];
    }

    private function getGreeting(): string
    {
        $hour = now()->format('H');

        if ($hour < 12) {
            return 'Good Morning';
        }
        if ($hour < 17) {
            return 'Good Afternoon';
        }
        return 'Good Evening';
    }
}

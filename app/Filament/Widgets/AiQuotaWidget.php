<?php

namespace App\Filament\Widgets;

use App\Models\AiConversation;
use Filament\Widgets\Widget;

class AiQuotaWidget extends Widget
{
    protected static string $view = 'filament.widgets.ai-quota';

    protected int | string | array $columnSpan = 'full';
    
    // We set sort to 2 so it sits perfectly between your Stats Overview and Today's Appointments
    protected static ?int $sort = 2; 

    public function getViewData(): array
    {
        $annualLimit = 500000;
        
        // Count all messages sent and received by the AI in the current year
        $usedQuota = AiConversation::whereYear('created_at', now()->year)->count();
        
        $remainingQuota = max(0, $annualLimit - $usedQuota);
        
        // Calculate percentage (capped at 100% so the UI bar doesn't break if you go over)
        $percentageUsed = min(100, ($usedQuota / $annualLimit) * 100);

        return [
            'annualLimit' => $annualLimit,
            'usedQuota' => $usedQuota,
            'remainingQuota' => $remainingQuota,
            'percentageUsed' => $percentageUsed,
        ];
    }
}

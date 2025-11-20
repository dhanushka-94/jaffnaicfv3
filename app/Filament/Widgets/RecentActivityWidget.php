<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $recentContact = ContactMessage::latest('created_at')->first();
        
        $stats = [];
        
        if ($recentContact) {
            $stats[] = Stat::make('Latest Contact', $recentContact->name)
                ->description('Received ' . $recentContact->created_at->diffForHumans())
                ->descriptionIcon('heroicon-m-envelope')
                ->color('danger');
        }
        
        return $stats;
    }
}

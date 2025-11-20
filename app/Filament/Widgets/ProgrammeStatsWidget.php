<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\DebutFilmImageResource;
use App\Filament\Resources\InternationalShortImageResource;
use App\Filament\Resources\JuryDebutImageResource;
use App\Filament\Resources\JuryShortImageResource;
use App\Filament\Resources\MasterclassImageResource;
use App\Filament\Resources\NationalShortImageResource;
use App\Filament\Resources\NewAsianCurrentImageResource;
use App\Filament\Resources\ScheduleImageResource;
use App\Models\DebutFilmImage;
use App\Models\InternationalShortImage;
use App\Models\JuryDebutImage;
use App\Models\JuryShortImage;
use App\Models\MasterclassImage;
use App\Models\NationalShortImage;
use App\Models\NewAsianCurrentImage;
use App\Models\ScheduleImage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProgrammeStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $currentYear = (int) date('Y');
        
        return [
            Stat::make('Schedule Images', ScheduleImage::where('year', $currentYear)->count())
                ->description('Current year schedule')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary')
                ->url(ScheduleImageResource::getUrl('index')),
            
            Stat::make('Masterclasses', MasterclassImage::where('year', $currentYear)->count())
                ->description('Current year masterclasses')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success')
                ->url(MasterclassImageResource::getUrl('index')),
            
            Stat::make('Debut Films', DebutFilmImage::where('year', $currentYear)->count())
                ->description('Current year debut films')
                ->descriptionIcon('heroicon-m-film')
                ->color('info')
                ->url(DebutFilmImageResource::getUrl('index')),
            
            Stat::make('Jury – Debut Films', JuryDebutImage::where('year', $currentYear)->count())
                ->description('Current year jury')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning')
                ->url(JuryDebutImageResource::getUrl('index')),
            
            Stat::make('Jury – Short Films', JuryShortImage::where('year', $currentYear)->count())
                ->description('Current year jury')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning')
                ->url(JuryShortImageResource::getUrl('index')),
            
            Stat::make('National Short Films', NationalShortImage::where('year', $currentYear)->count())
                ->description('Current year national shorts')
                ->descriptionIcon('heroicon-m-flag')
                ->color('danger')
                ->url(NationalShortImageResource::getUrl('index')),
            
            Stat::make('International Short Films', InternationalShortImage::where('year', $currentYear)->count())
                ->description('Current year international shorts')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('info')
                ->url(InternationalShortImageResource::getUrl('index')),
            
            Stat::make('New Asian Currents', NewAsianCurrentImage::where('year', $currentYear)->count())
                ->description('Current year new asian currents')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('success')
                ->url(NewAsianCurrentImageResource::getUrl('index')),
        ];
    }
}


<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\GalleryImageResource;
use App\Filament\Resources\PartnerResource;
use App\Filament\Resources\ReviewResource;
use App\Filament\Resources\SliderResource;
use App\Filament\Resources\TeamMemberResource;
use App\Filament\Resources\VenueResource;
use App\Models\ContactMessage;
use App\Models\DebutFilmImage;
use App\Models\GalleryImage;
use App\Models\InternationalShortImage;
use App\Models\JuryDebutImage;
use App\Models\JuryShortImage;
use App\Models\MasterclassImage;
use App\Models\NationalShortImage;
use App\Models\NewAsianCurrentImage;
use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Models\Review;
use App\Models\ScheduleImage;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Venue;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $currentYear = (int) date('Y');
        
        return [
            Stat::make('Active Sliders', Slider::where('is_active', true)->count())
                ->description('Homepage hero sliders')
                ->descriptionIcon('heroicon-m-photo')
                ->color('success')
                ->url(SliderResource::getUrl('index')),
            
            Stat::make('Team Members', TeamMember::where('year', $currentYear)->count())
                ->description('Current year (' . $currentYear . ') team')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->url(TeamMemberResource::getUrl('index')),
            
            Stat::make('Partners', Partner::where('year', $currentYear)->count())
                ->description(PartnerCategory::count() . ' categories')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('warning')
                ->url(PartnerResource::getUrl('index')),
            
            Stat::make('Venues', Venue::where('year', $currentYear)->count())
                ->description('Current year venues')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('danger')
                ->url(VenueResource::getUrl('index')),
            
            Stat::make('Gallery Images', GalleryImage::where('is_active', true)->count())
                ->description('Active gallery items')
                ->descriptionIcon('heroicon-m-photo')
                ->color('success')
                ->url(GalleryImageResource::getUrl('index')),
            
            Stat::make('Reviews', Review::where('is_active', true)->count())
                ->description('Active testimonials')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info')
                ->url(ReviewResource::getUrl('index')),
            
            Stat::make('Contact Messages', ContactMessage::count())
                ->description('Total messages received')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),
            
            Stat::make('Programme Images', 
                ScheduleImage::where('year', $currentYear)->count() +
                MasterclassImage::where('year', $currentYear)->count() +
                DebutFilmImage::where('year', $currentYear)->count() +
                JuryDebutImage::where('year', $currentYear)->count() +
                JuryShortImage::where('year', $currentYear)->count() +
                NationalShortImage::where('year', $currentYear)->count() +
                InternationalShortImage::where('year', $currentYear)->count() +
                NewAsianCurrentImage::where('year', $currentYear)->count()
            )
                ->description('Current year programme images')
                ->descriptionIcon('heroicon-m-film')
                ->color('danger'),
        ];
    }
}


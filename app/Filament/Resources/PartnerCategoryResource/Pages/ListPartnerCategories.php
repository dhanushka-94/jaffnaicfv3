<?php

namespace App\Filament\Resources\PartnerCategoryResource\Pages;

use App\Filament\Resources\PartnerCategoryResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListPartnerCategories extends ListRecords
{
    protected static string $resource = PartnerCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Create action is in table headerActions
        ];
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'Use the reorder button (arrows icon) and drag categories into the order they should appear on the Partners page.';
    }
}

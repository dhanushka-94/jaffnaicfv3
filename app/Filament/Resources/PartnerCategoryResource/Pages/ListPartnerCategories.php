<?php

namespace App\Filament\Resources\PartnerCategoryResource\Pages;

use App\Filament\Resources\PartnerCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPartnerCategories extends ListRecords
{
    protected static string $resource = PartnerCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}


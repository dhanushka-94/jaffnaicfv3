<?php

namespace App\Filament\Resources\PartnerCategoryResource\Pages;

use App\Filament\Resources\PartnerCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPartnerCategory extends EditRecord
{
    protected static string $resource = PartnerCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}


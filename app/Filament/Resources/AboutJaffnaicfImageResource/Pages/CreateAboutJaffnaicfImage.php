<?php

namespace App\Filament\Resources\AboutJaffnaicfImageResource\Pages;

use App\Filament\Resources\AboutJaffnaicfImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutJaffnaicfImage extends CreateRecord
{
    protected static string $resource = AboutJaffnaicfImageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}


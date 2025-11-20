<?php

namespace App\Filament\Resources\VenueResource\Pages;

use App\Filament\Resources\VenueResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVenue extends CreateRecord
{
    protected static string $resource = VenueResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['year']) || $data['year'] === '' || $data['year'] === null) {
            $data['year'] = (int) date('Y');
        } else {
            $data['year'] = (int) $data['year'];
        }
        
        return $data;
    }
}



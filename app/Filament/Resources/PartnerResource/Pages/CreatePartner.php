<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Filament\Resources\PartnerResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePartner extends CreateRecord
{
    protected static string $resource = PartnerResource::class;

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


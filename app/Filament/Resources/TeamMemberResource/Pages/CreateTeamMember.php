<?php

namespace App\Filament\Resources\TeamMemberResource\Pages;

use App\Filament\Resources\TeamMemberResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateTeamMember extends CreateRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['year']) || $data['year'] === '' || $data['year'] === null) {
            $data['year'] = (int) date('Y');
        } else {
            $data['year'] = (int) $data['year'];
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Team member created')
            ->body('The team member has been created successfully.');
    }
}



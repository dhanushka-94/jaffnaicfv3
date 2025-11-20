<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use Filament\Resources\Pages\CreateRecord;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateGalleryImage extends CreateRecord
{
    protected static string $resource = GalleryImageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Handle multiple image uploads
        if (isset($data['image_paths'])) {
            $imagePaths = [];
            
            // Handle both array and single file
            $images = is_array($data['image_paths']) ? $data['image_paths'] : [$data['image_paths']];
            
            foreach ($images as $image) {
                if ($image instanceof TemporaryUploadedFile) {
                    $storedPath = $image->store('gallery', 'public');
                    $imagePaths[] = $storedPath;
                } elseif (is_string($image) && !empty($image)) {
                    $imagePaths[] = $image;
                }
            }
            
            $data['image_paths'] = $imagePaths;
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}


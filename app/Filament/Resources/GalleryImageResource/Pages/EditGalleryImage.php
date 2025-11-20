<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use Filament\Resources\Pages\EditRecord;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditGalleryImage extends EditRecord
{
    protected static string $resource = GalleryImageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Convert image_paths array to form data
        if (isset($this->record->image_paths) && is_array($this->record->image_paths)) {
            $data['image_paths'] = $this->record->image_paths;
        } elseif (isset($this->record->image_path)) {
            // Fallback to single image_path for backward compatibility
            $data['image_paths'] = [$this->record->image_path];
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle multiple image uploads
        if (isset($data['image_paths'])) {
            $existingPaths = $this->record->image_paths ?? [];
            $newPaths = [];
            
            // Handle both array and single file
            $images = is_array($data['image_paths']) ? $data['image_paths'] : [$data['image_paths']];
            
            foreach ($images as $image) {
                if ($image instanceof TemporaryUploadedFile) {
                    $storedPath = $image->store('gallery', 'public');
                    $newPaths[] = $storedPath;
                } elseif (is_string($image) && !empty($image)) {
                    // Keep existing paths
                    $newPaths[] = $image;
                }
            }
            
            $data['image_paths'] = array_filter($newPaths);
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}


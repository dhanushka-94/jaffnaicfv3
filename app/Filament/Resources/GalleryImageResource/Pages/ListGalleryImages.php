<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use App\Models\GalleryImage;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ListGalleryImages extends ListRecords
{
    protected static string $resource = GalleryImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('bulkUpload')
                ->label('Bulk Upload Images')
                ->icon('heroicon-o-photo')
                ->color('success')
                ->form([
                    FileUpload::make('images')
                        ->label('Select Images')
                        ->image()
                        ->multiple()
                        ->directory('gallery')
                        ->disk('public')
                        ->visibility('public')
                        ->required()
                        ->maxFiles(100)
                        ->helperText('You can select multiple images at once (up to 100 images). They will be grouped by title.'),
                    TextInput::make('title')
                        ->label('Title')
                        ->maxLength(255)
                        ->nullable()
                        ->helperText('Optional title for all uploaded images. If provided, all images will be grouped under this title.'),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(3)
                        ->maxLength(500)
                        ->nullable()
                        ->helperText('Optional description for all uploaded images.'),
                    Toggle::make('is_active')
                        ->label('Set all images as active')
                        ->default(true),
                    Toggle::make('group_by_title')
                        ->label('Group all images under one title')
                        ->default(true)
                        ->helperText('If enabled, all images will be in one gallery item. If disabled, each image will be a separate item.'),
                ])
                ->action(function (array $data) {
                    $images = $data['images'] ?? [];
                    $isActive = $data['is_active'] ?? true;
                    $title = $data['title'] ?? null;
                    $description = $data['description'] ?? null;
                    $groupByTitle = $data['group_by_title'] ?? true;
                    $maxOrder = GalleryImage::max('sort_order') ?? 0;

                    // Handle both single file (string) and multiple files (array)
                    if (!is_array($images)) {
                        $images = [$images];
                    }

                    $imagePaths = [];
                    foreach ($images as $image) {
                        if (empty($image)) {
                            continue;
                        }

                        // Handle TemporaryUploadedFile objects
                        if ($image instanceof TemporaryUploadedFile) {
                            $storedPath = $image->store('gallery', 'public');
                            $imagePaths[] = $storedPath;
                        } elseif (is_string($image)) {
                            $imagePaths[] = $image;
                        }
                    }

                    if (empty($imagePaths)) {
                        Notification::make()
                            ->title('No images uploaded')
                            ->body('Please select at least one image to upload.')
                            ->warning()
                            ->send();
                        return;
                    }

                    $created = 0;
                    
                    if ($groupByTitle) {
                        // Create one record with all images
                        GalleryImage::create([
                            'title' => $title,
                            'description' => $description,
                            'image_paths' => $imagePaths,
                            'is_active' => $isActive,
                            'sort_order' => $maxOrder + 1,
                        ]);
                        $created = 1;
                        $imageCount = count($imagePaths);
                    } else {
                        // Create separate record for each image
                        foreach ($imagePaths as $index => $imagePath) {
                            GalleryImage::create([
                                'title' => $title,
                                'description' => $description,
                                'image_paths' => [$imagePath],
                                'is_active' => $isActive,
                                'sort_order' => $maxOrder + $index + 1,
                            ]);
                            $created++;
                        }
                        $imageCount = count($imagePaths);
                    }

                    Notification::make()
                        ->title('Images uploaded successfully')
                        ->body($groupByTitle 
                            ? "Created 1 gallery item with {$imageCount} image(s)."
                            : "Created {$created} gallery item(s) with {$imageCount} total image(s).")
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('Bulk Upload Gallery Images')
                ->modalDescription('Upload multiple images at once. They will be added to the gallery in the order you select them.'),
        ];
    }
}


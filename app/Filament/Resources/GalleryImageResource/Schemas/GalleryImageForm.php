<?php

namespace App\Filament\Resources\GalleryImageResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GalleryImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_paths')
                    ->label('Gallery Images')
                    ->image()
                    ->multiple()
                    ->directory('gallery')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->required()
                    ->minFiles(1)
                    ->maxFiles(20)
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->helperText('Upload one or multiple images for this gallery item. You can upload up to 20 images per item.'),
                TextInput::make('title')
                    ->label('Title')
                    ->maxLength(255)
                    ->nullable()
                    ->helperText('Optional title for the image.'),
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(500)
                    ->nullable()
                    ->helperText('Optional description for the image.'),
                TextInput::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Lower numbers appear first. You can also drag to reorder in the list.'),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Inactive images will not be displayed on the frontend.'),
            ]);
    }
}


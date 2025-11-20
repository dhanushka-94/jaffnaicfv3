<?php

namespace App\Filament\Resources\SliderResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_path')
                    ->label('Desktop Slide Image')
                    ->image()
                    ->directory('sliders')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->required()
                    ->helperText('Recommended size: 1920px × 1080px (16:9 ratio). Image displayed on desktop and tablet devices.'),
                FileUpload::make('mobile_image_path')
                    ->label('Mobile Slide Image')
                    ->image()
                    ->directory('sliders/mobile')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->nullable()
                    ->helperText('Recommended size: 1080px × 1440px (3:4 ratio - portrait). Optional: Separate image for mobile devices. If not provided, desktop image will be used.'),
                TextInput::make('title')
                    ->maxLength(190)
                    ->nullable(),
                TextInput::make('subtitle')
                    ->maxLength(190)
                    ->nullable(),
                TextInput::make('button_text')
                    ->maxLength(120)
                    ->label('Button Text')
                    ->nullable(),
                TextInput::make('button_url')
                    ->maxLength(255)
                    ->label('Button URL')
                    ->url()
                    ->nullable(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->label('Order'),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}



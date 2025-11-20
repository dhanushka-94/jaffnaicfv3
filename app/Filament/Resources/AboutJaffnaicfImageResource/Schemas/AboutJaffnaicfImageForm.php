<?php

namespace App\Filament\Resources\AboutJaffnaicfImageResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AboutJaffnaicfImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->directory('about/jaffnaicf')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->required()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->helperText('Upload image for the JAFFNAICF about page.'),
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


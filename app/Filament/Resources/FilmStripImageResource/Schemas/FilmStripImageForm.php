<?php

namespace App\Filament\Resources\FilmStripImageResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FilmStripImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->directory('film-strip')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->required()
                    ->helperText('Shown in the sliding strip under the homepage hero. A wide photo works best.'),
                TextInput::make('title')
                    ->label('Caption')
                    ->maxLength(190)
                    ->nullable()
                    ->helperText('Used as the image description. It is not printed on the strip.'),
                TextInput::make('sort_order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->label('Order'),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Turn off to hide this photo without deleting it.'),
            ]);
    }
}

<?php

namespace App\Filament\Resources\ProgrammeImageResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProgrammeImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(2100)
                    ->default(fn () => (int) date('Y'))
                    ->required(),
                Select::make('section')
                    ->required()
                    ->options([
                        'schedule' => 'Schedule',
                        'masterclasses' => 'Masterclasses',
                        'debut_films' => 'Debut Films',
                        'jury_debut' => 'Jury – Debut Films',
                        'jury_short' => 'Jury – Short Films',
                        'national_shorts' => 'National Short Films',
                        'international_shorts' => 'International Short Films',
                        'new_asian_currents' => 'New Asian Currents',
                    ]),
                FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->directory('programme')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->required(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->label('Order'),
            ]);
    }
}



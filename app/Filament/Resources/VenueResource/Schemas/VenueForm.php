<?php

namespace App\Filament\Resources\VenueResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VenueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->label('Year')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(2100)
                    ->default(fn () => (int) date('Y'))
                    ->required()
                    ->helperText('The festival year this venue belongs to.'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(190),
                TextInput::make('address')
                    ->label('Address')
                    ->maxLength(255)
                    ->nullable(),
                Textarea::make('contacts')
                    ->label('Contacts (e.g. phone numbers)')
                    ->rows(2)
                    ->nullable(),
                Textarea::make('map_iframe')
                    ->label('Google Maps iframe code')
                    ->rows(4)
                    ->helperText('Paste the full iframe embed code from Google Maps.')
                    ->nullable(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->label('Order'),
            ]);
    }
}



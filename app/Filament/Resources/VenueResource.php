<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VenueResource\Pages\CreateVenue;
use App\Filament\Resources\VenueResource\Pages\EditVenue;
use App\Filament\Resources\VenueResource\Pages\ListVenues;
use App\Filament\Resources\VenueResource\Schemas\VenueForm;
use App\Filament\Resources\VenueResource\Tables\VenuesTable;
use App\Models\Venue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VenueResource extends Resource
{
    protected static ?string $model = Venue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static UnitEnum|string|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return VenueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VenuesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVenues::route('/'),
            'create' => CreateVenue::route('/create'),
            'edit' => EditVenue::route('/{record}/edit'),
        ];
    }
}



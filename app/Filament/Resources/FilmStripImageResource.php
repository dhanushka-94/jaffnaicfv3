<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FilmStripImageResource\Pages\CreateFilmStripImage;
use App\Filament\Resources\FilmStripImageResource\Pages\EditFilmStripImage;
use App\Filament\Resources\FilmStripImageResource\Pages\ListFilmStripImages;
use App\Filament\Resources\FilmStripImageResource\Schemas\FilmStripImageForm;
use App\Filament\Resources\FilmStripImageResource\Tables\FilmStripImagesTable;
use App\Models\FilmStripImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FilmStripImageResource extends Resource
{
    protected static ?string $model = FilmStripImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFilm;

    protected static ?string $navigationLabel = 'Film Strip';

    protected static ?string $modelLabel = 'film strip image';

    protected static ?string $pluralModelLabel = 'Film Strip';

    protected static UnitEnum|string|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 11;

    public static function form(Schema $schema): Schema
    {
        return FilmStripImageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilmStripImagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFilmStripImages::route('/'),
            'create' => CreateFilmStripImage::route('/create'),
            'edit' => EditFilmStripImage::route('/{record}/edit'),
        ];
    }
}

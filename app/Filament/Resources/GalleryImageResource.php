<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryImageResource\Pages\CreateGalleryImage;
use App\Filament\Resources\GalleryImageResource\Pages\EditGalleryImage;
use App\Filament\Resources\GalleryImageResource\Pages\ListGalleryImages;
use App\Filament\Resources\GalleryImageResource\Schemas\GalleryImageForm;
use App\Filament\Resources\GalleryImageResource\Tables\GalleryImagesTable;
use App\Models\GalleryImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static UnitEnum|string|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 15;

    public static function form(Schema $schema): Schema
    {
        return GalleryImageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GalleryImagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGalleryImages::route('/'),
            'create' => CreateGalleryImage::route('/create'),
            'edit' => EditGalleryImage::route('/{record}/edit'),
        ];
    }
}


<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutJaffnaicfImageResource\Pages\CreateAboutJaffnaicfImage;
use App\Filament\Resources\AboutJaffnaicfImageResource\Pages\EditAboutJaffnaicfImage;
use App\Filament\Resources\AboutJaffnaicfImageResource\Pages\ListAboutJaffnaicfImages;
use App\Filament\Resources\AboutJaffnaicfImageResource\Schemas\AboutJaffnaicfImageForm;
use App\Filament\Resources\AboutJaffnaicfImageResource\Tables\AboutJaffnaicfImagesTable;
use App\Models\AboutJaffnaicfImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AboutJaffnaicfImageResource extends Resource
{
    protected static ?string $model = AboutJaffnaicfImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static UnitEnum|string|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'About > JAFFNAICF Images';

    public static function form(Schema $schema): Schema
    {
        return AboutJaffnaicfImageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutJaffnaicfImagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAboutJaffnaicfImages::route('/'),
            'create' => CreateAboutJaffnaicfImage::route('/create'),
            'edit' => EditAboutJaffnaicfImage::route('/{record}/edit'),
        ];
    }
}


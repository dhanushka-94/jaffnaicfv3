<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgrammeImageResource\Pages\CreateProgrammeImage;
use App\Filament\Resources\ProgrammeImageResource\Pages\EditProgrammeImage;
use App\Filament\Resources\ProgrammeImageResource\Pages\ListProgrammeImages;
use App\Filament\Resources\ProgrammeImageResource\Schemas\ProgrammeImageForm;
use App\Filament\Resources\ProgrammeImageResource\Tables\ProgrammeImagesTable;
use App\Models\ProgrammeImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProgrammeImageResource extends Resource
{
    protected static ?string $model = ProgrammeImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static UnitEnum|string|null $navigationGroup = 'Programme';
    protected static ?int $navigationSort = 90;

    public static function form(Schema $schema): Schema
    {
        return ProgrammeImageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgrammeImagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProgrammeImages::route('/'),
            'create' => CreateProgrammeImage::route('/create'),
            'edit' => EditProgrammeImage::route('/{record}/edit'),
        ];
    }
}



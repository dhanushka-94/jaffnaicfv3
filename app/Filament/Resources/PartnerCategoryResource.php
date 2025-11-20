<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerCategoryResource\Pages\CreatePartnerCategory;
use App\Filament\Resources\PartnerCategoryResource\Pages\EditPartnerCategory;
use App\Filament\Resources\PartnerCategoryResource\Pages\ListPartnerCategories;
use App\Filament\Resources\PartnerCategoryResource\Schemas\PartnerCategoryForm;
use App\Filament\Resources\PartnerCategoryResource\Tables\PartnerCategoriesTable;
use App\Models\PartnerCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PartnerCategoryResource extends Resource
{
    protected static ?string $model = PartnerCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static UnitEnum|string|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return PartnerCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartnerCategoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartnerCategories::route('/'),
            'create' => CreatePartnerCategory::route('/create'),
            'edit' => EditPartnerCategory::route('/{record}/edit'),
        ];
    }
}


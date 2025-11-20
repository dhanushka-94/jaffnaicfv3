<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages\CreatePartner;
use App\Filament\Resources\PartnerResource\Pages\EditPartner;
use App\Filament\Resources\PartnerResource\Pages\ListPartners;
use App\Filament\Resources\PartnerResource\Schemas\PartnerForm;
use App\Filament\Resources\PartnerResource\Tables\PartnersTable;
use App\Models\Partner;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static UnitEnum|string|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 35;

    public static function form(Schema $schema): Schema
    {
        return PartnerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartnersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartners::route('/'),
            'create' => CreatePartner::route('/create'),
            'edit' => EditPartner::route('/{record}/edit'),
        ];
    }
}


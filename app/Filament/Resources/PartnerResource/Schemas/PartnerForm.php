<?php

namespace App\Filament\Resources\PartnerResource\Schemas;

use App\Models\PartnerCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PartnerForm
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
                    ->helperText('The festival year this partner belongs to.'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(120),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(120),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ])
                    ->nullable(),
                FileUpload::make('logo_path')
                    ->label('Logo')
                    ->image()
                    ->directory('partners')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->nullable(),
                TextInput::make('url')
                    ->label('Website URL')
                    ->url()
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->label('Order'),
            ]);
    }
}


<?php

namespace App\Filament\Resources\TeamMemberResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeamMemberForm
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
                    ->helperText('The festival year this team member belongs to.'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(120),
                TextInput::make('role')
                    ->maxLength(120),
                FileUpload::make('photo_path')
                    ->label('Photo')
                    ->image()
                    ->directory('team')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->nullable(),
                TextInput::make('email')
                    ->email()
                    ->maxLength(190)
                    ->nullable(),
                TextInput::make('phone')
                    ->maxLength(60)
                    ->nullable(),
                Textarea::make('bio')
                    ->rows(5)
                    ->nullable(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->label('Order'),
            ]);
    }
}



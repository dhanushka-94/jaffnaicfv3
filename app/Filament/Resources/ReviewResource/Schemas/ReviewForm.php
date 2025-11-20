<?php

namespace App\Filament\Resources\ReviewResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Full name of the reviewer.'),
                TextInput::make('designation')
                    ->label('Designation')
                    ->maxLength(255)
                    ->nullable()
                    ->helperText('Job title or position (e.g., Director, Film Critic).'),
                TextInput::make('company')
                    ->label('Company')
                    ->maxLength(255)
                    ->nullable()
                    ->helperText('Organization or company name (optional).'),
                Textarea::make('review')
                    ->label('Review')
                    ->required()
                    ->rows(5)
                    ->maxLength(1000)
                    ->helperText('The review or testimonial text.'),
                TextInput::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Lower numbers appear first. You can also drag to reorder in the list.'),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Inactive reviews will not be displayed on the frontend.'),
            ]);
    }
}


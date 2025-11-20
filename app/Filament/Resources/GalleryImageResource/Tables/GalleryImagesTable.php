<?php

namespace App\Filament\Resources\GalleryImageResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GalleryImagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Preview')
                    ->disk('public')
                    ->square()
                    ->size(80)
                    ->getStateUsing(function ($record) {
                        // Show first image from image_paths array, or fallback to image_path
                        $paths = $record->getAllImagePaths();
                        return $paths[0] ?? $record->image_path;
                    }),
                TextColumn::make('title')
                    ->label('Title')
                    ->limit(40)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('image_count')
                    ->label('Images')
                    ->getStateUsing(function ($record) {
                        $paths = $record->getAllImagePaths();
                        return count($paths);
                    })
                    ->badge()
                    ->color('primary'),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->toggleable()
                    ->wrap(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}


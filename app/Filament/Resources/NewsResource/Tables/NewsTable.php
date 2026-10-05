<?php

namespace App\Filament\Resources\NewsResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('feature_image_path')
                    ->label('Image')
                    ->disk('public')
                    ->square()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->placeholder('Draft'),
                TextColumn::make('meta_title')
                    ->label('SEO title')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('Auto'),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Filter::make('published')
                    ->label('Published only')
                    ->query(fn (Builder $query) => $query->published()),
                Filter::make('draft')
                    ->label('Drafts only')
                    ->query(fn (Builder $query) => $query->whereNull('published_at')),
            ])
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

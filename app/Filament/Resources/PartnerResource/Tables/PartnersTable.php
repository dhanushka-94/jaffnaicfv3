<?php

namespace App\Filament\Resources\PartnerResource\Tables;

use App\Models\Partner;
use App\Models\PartnerCategory;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // While dragging, Filament sorts by sort_order only. Keep each category
            // together, in the same order as the public Partners page, so a drag
            // changes the order of logos inside their category.
            ->modifyQueryUsing(fn (Builder $query) => $table->isReordering()
                ? $query->orderByRaw('category_id IS NULL')->orderBy(
                    PartnerCategory::query()->select('sort_order')->whereColumn('partner_categories.id', 'partners.category_id')
                )
                : $query)
            ->reorderable('sort_order')
            ->groups([
                Group::make('category.name')
                    ->label('Category')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false)
                    ->orderQueryUsing(fn (Builder $query, string $direction) => $query
                        ->orderByRaw('category_id IS NULL')
                        ->orderBy(
                            PartnerCategory::query()->select('sort_order')->whereColumn('partner_categories.id', 'partners.category_id'),
                            $direction === 'desc' ? 'desc' : 'asc',
                        ))
                    ->getTitleFromRecordUsing(fn (Partner $record): string => $record->category?->name ?? 'No category'),
            ])
            ->defaultGroup('category.name')
            ->groupingSettingsHidden()
            ->defaultSort('sort_order')
            ->paginationPageOptions([25, 50, 100])
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),
                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->searchable(),
                TextColumn::make('year')
                    ->label('Year')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('url')
                    ->label('Website')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Years are handled by the tabs on the list page.
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(fn () => PartnerCategory::query()->orderBy('sort_order')->pluck('name', 'id'))
                    ->placeholder('All categories'),
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
                    BulkAction::make('archive')
                        ->label('Archive to Year')
                        ->icon('heroicon-o-archive-box')
                        ->color('warning')
                        ->form([
                            Select::make('year')
                                ->label('Archive Year')
                                ->options(function () {
                                    $currentYear = (int) date('Y');
                                    $years = [];
                                    // Generate last 15 years + current year
                                    for ($i = 0; $i <= 15; $i++) {
                                        $year = $currentYear - $i;
                                        $years[$year] = $year . ($year < $currentYear ? ' (Archive)' : ($year == $currentYear ? ' (Current)' : ''));
                                    }
                                    return $years;
                                })
                                ->default(function () {
                                    $currentYear = (int) date('Y');
                                    return $currentYear - 1; // Default to last year
                                })
                                ->required()
                                ->searchable()
                                ->helperText('Select the year to archive these items to. Items will appear in the archive for that year.'),
                        ])
                        ->action(function ($records, array $data) {
                            $year = (int) $data['year'];
                            $currentYear = (int) date('Y');
                            $isArchive = $year < $currentYear;
                            
                            $records->each(function ($record) use ($year) {
                                $record->update(['year' => $year]);
                            });
                            
                            $message = $isArchive 
                                ? 'Archived ' . $records->count() . ' partner(s) to ' . $year
                                : 'Updated ' . $records->count() . ' partner(s) to year ' . $year;
                            
                            Notification::make()
                                ->title($isArchive ? 'Archived successfully' : 'Year updated successfully')
                                ->body($message)
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalHeading('Archive Partners')
                        ->modalDescription('Select the year to archive the selected partners to.'),
                    BulkAction::make('updateYear')
                        ->label('Change Year')
                        ->icon('heroicon-o-calendar')
                        ->form([
                            TextInput::make('year')
                                ->label('Year')
                                ->numeric()
                                ->minValue(2000)
                                ->maxValue(2100)
                                ->default(date('Y'))
                                ->required()
                                ->helperText('Set the year for all selected partners.'),
                        ])
                        ->action(function ($records, array $data) {
                            $records->each(function ($record) use ($data) {
                                $record->update(['year' => $data['year']]);
                            });
                            
                            Notification::make()
                                ->title('Year updated successfully')
                                ->body('Updated ' . $records->count() . ' partner(s) to year ' . $data['year'])
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}


<?php

namespace App\Filament\Resources\VenueResource\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VenuesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('year')
                    ->label('Year')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('contacts')
                    ->limit(40)
                    ->label('Contacts')
                    ->toggleable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->defaultSort('year', 'desc')
            ->filters([
                SelectFilter::make('year')
                    ->label('Year')
                    ->options(function () {
                        return \App\Models\Venue::query()
                            ->select('year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray();
                    })
                    ->default(date('Y')),
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
                                ? 'Archived ' . $records->count() . ' venue(s) to ' . $year
                                : 'Updated ' . $records->count() . ' venue(s) to year ' . $year;
                            
                            Notification::make()
                                ->title($isArchive ? 'Archived successfully' : 'Year updated successfully')
                                ->body($message)
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalHeading('Archive Venues')
                        ->modalDescription('Select the year to archive the selected venues to.'),
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
                                ->helperText('Set the year for all selected venues.'),
                        ])
                        ->action(function ($records, array $data) {
                            $records->each(function ($record) use ($data) {
                                $record->update(['year' => $data['year']]);
                            });
                            
                            Notification::make()
                                ->title('Year updated successfully')
                                ->body('Updated ' . $records->count() . ' venue(s) to year ' . $data['year'])
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



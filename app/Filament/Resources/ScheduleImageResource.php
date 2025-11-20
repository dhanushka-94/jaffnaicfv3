<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleImageResource\Pages\CreateScheduleImage;
use App\Filament\Resources\ScheduleImageResource\Pages\EditScheduleImage;
use App\Filament\Resources\ScheduleImageResource\Pages\ListScheduleImages;
use App\Models\ScheduleImage;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class ScheduleImageResource extends Resource
{
    protected static ?string $model = ScheduleImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static UnitEnum|string|null $navigationGroup = 'Programme';
    protected static ?int $navigationSort = 50;

    protected static ?string $navigationLabel = 'Schedule';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(2100)
                    ->default(fn () => (int) date('Y'))
                    ->required(),
                FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->directory('programme/schedule')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->required(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->label('Order'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->square(),
                TextColumn::make('year')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->defaultSort('year', 'desc')
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
                                    for ($i = 0; $i <= 15; $i++) {
                                        $year = $currentYear - $i;
                                        $years[$year] = $year . ($year < $currentYear ? ' (Archive)' : ($year == $currentYear ? ' (Current)' : ''));
                                    }
                                    return $years;
                                })
                                ->default(function () {
                                    return (int) date('Y') - 1;
                                })
                                ->required()
                                ->searchable()
                                ->helperText('Select the year to archive these images to.'),
                        ])
                        ->action(function ($records, array $data) {
                            $year = (int) $data['year'];
                            $currentYear = (int) date('Y');
                            $isArchive = $year < $currentYear;
                            
                            $records->each(function ($record) use ($year) {
                                $record->update(['year' => $year]);
                            });
                            
                            Notification::make()
                                ->title($isArchive ? 'Archived successfully' : 'Year updated successfully')
                                ->body(($isArchive ? 'Archived' : 'Updated') . ' ' . $records->count() . ' image(s) to ' . $year)
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalHeading('Archive Schedule Images')
                        ->modalDescription('Select the year to archive the selected images to.'),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScheduleImages::route('/'),
            'create' => CreateScheduleImage::route('/create'),
            'edit' => EditScheduleImage::route('/{record}/edit'),
        ];
    }
}



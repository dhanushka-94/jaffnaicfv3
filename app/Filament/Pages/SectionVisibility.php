<?php

namespace App\Filament\Pages;

use App\Models\SectionSetting;
use BackedEnum;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use UnitEnum;

class SectionVisibility extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationLabel = 'Section Visibility';
    protected static ?string $title = 'Section Visibility';
    protected static UnitEnum|string|null $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.section-visibility';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SectionSetting::all()->keyBy('key');

        $this->form->fill(
            $settings->mapWithKeys(fn ($setting) => [
                $setting->key => (bool) $setting->is_active,
            ])->toArray()
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('programme_schedule')
                    ->label('Programme — Schedule')
                    ->default(true),
                Toggle::make('programme_masterclasses')
                    ->label('Programme — Masterclasses')
                    ->default(true),
                Toggle::make('programme_debut_films')
                    ->label('Programme — Debut Films')
                    ->default(true),
                Toggle::make('programme_jury_debut')
                    ->label('Programme — Jury – Debut Films')
                    ->default(true),
                Toggle::make('programme_jury_short')
                    ->label('Programme — Jury – Short Films')
                    ->default(true),
                Toggle::make('programme_national_shorts')
                    ->label('Programme — National Short Films')
                    ->default(true),
                Toggle::make('programme_international_shorts')
                    ->label('Programme — International Short Films')
                    ->default(true),
                Toggle::make('programme_new_asian_currents')
                    ->label('Programme — New Asian Currents')
                    ->default(true),
                Toggle::make('programme_images')
                    ->label('Programme — General Images')
                    ->default(true),
                Toggle::make('team_members')
                    ->label('Team Members')
                    ->default(true),
                Toggle::make('venues')
                    ->label('Venues')
                    ->default(true),
                Toggle::make('partners')
                    ->label('Partners')
                    ->default(true),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            SectionSetting::where('key', $key)->update(['is_active' => (bool) $value]);
        }

        Notification::make()
            ->title('Section visibility updated.')
            ->success()
            ->send();
    }
}



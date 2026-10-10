<?php

namespace App\Filament\Pages;

use App\Models\SectionSetting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class SectionVisibility extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationLabel = 'Section Visibility';

    protected static ?string $title = 'Section Visibility';

    protected static UnitEnum|string|null $navigationGroup = 'Configuration';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.section-visibility';

    /** @var array<string, bool> */
    public array $visibility = [];

    public function mount(): void
    {
        $this->visibility = $this->visibilityState();
    }

    public function toggle(string $key): void
    {
        if (! array_key_exists($key, SectionSetting::definitions())) {
            return;
        }

        $this->visibility[$key] = ! $this->isOn($key);
    }

    public function setGroup(string $group, bool $active): void
    {
        foreach ($this->groupKeys()[$group] ?? [] as $key) {
            $this->visibility[$key] = $active;
        }
    }

    public function save(): void
    {
        foreach (SectionSetting::definitions() as $key => $label) {
            SectionSetting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'label' => $label,
                    'is_active' => $this->isOn($key),
                ],
            );
        }

        $this->visibility = $this->visibilityState();

        Notification::make()
            ->title('Section visibility updated.')
            ->success()
            ->send();
    }

    public function isOn(string $key): bool
    {
        return filter_var($this->visibility[$key] ?? false, FILTER_VALIDATE_BOOLEAN);
    }

    public function showingCount(): int
    {
        return collect(array_keys(SectionSetting::definitions()))
            ->filter(fn (string $key): bool => $this->isOn($key))
            ->count();
    }

    /** @return array<string, list<string>> */
    public function groupKeys(): array
    {
        return [
            'Programme' => [
                'programme_schedule',
                'programme_masterclasses',
                'programme_debut_films',
                'programme_jury_debut',
                'programme_jury_short',
                'programme_national_shorts',
                'programme_international_shorts',
                'programme_new_asian_currents',
                'programme_images',
            ],
            'Festival' => [
                'team_members',
                'venues',
                'partners',
            ],
        ];
    }

    /** @return array<string, bool> */
    protected function visibilityState(): array
    {
        $saved = SectionSetting::query()->pluck('is_active', 'key');
        $state = [];

        foreach (SectionSetting::definitions() as $key => $label) {
            $state[$key] = filter_var($saved[$key] ?? true, FILTER_VALIDATE_BOOLEAN);
        }

        return $state;
    }
}

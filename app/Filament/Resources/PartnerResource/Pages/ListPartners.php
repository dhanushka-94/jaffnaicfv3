<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Filament\Resources\PartnerResource;
use App\Models\Partner;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListPartners extends ListRecords
{
    protected static string $resource = PartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Create action is in table headerActions
        ];
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'Pick a year tab. Drag logos with the reorder button (arrows icon) to set their order inside each category. Category order is set on Partner Categories.';
    }

    /**
     * One tab per festival year, newest first, plus an "All years" tab.
     *
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        $currentYear = (int) date('Y');

        $counts = Partner::query()
            ->selectRaw('year, COUNT(*) as total')
            ->groupBy('year')
            ->pluck('total', 'year');

        $years = $counts->keys()
            ->map(fn ($year) => (int) $year)
            ->push($currentYear)
            ->unique()
            ->sortDesc()
            ->values();

        $tabs = [];

        foreach ($years as $year) {
            $label = $year === $currentYear ? $year . ' (Current)' : $year . ' (Archive)';

            $tabs[(string) $year] = Tab::make($label)
                ->badge((int) ($counts[$year] ?? 0))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('year', $year));
        }

        $tabs['all'] = Tab::make('All years')
            ->badge((int) $counts->sum());

        return $tabs;
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return (string) (int) date('Y');
    }
}

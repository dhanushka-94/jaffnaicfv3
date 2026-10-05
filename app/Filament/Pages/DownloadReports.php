<?php

namespace App\Filament\Pages;

use App\Models\ApplicationDownloadLog;
use App\Models\ApplicationDownloadStat;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use UnitEnum;

class DownloadReports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Download Reports';

    protected static ?string $title = 'Application Download Reports';

    protected static UnitEnum|string|null $navigationGroup = 'Reports';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.download-reports';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'from' => null,
            'to' => null,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('from')
                    ->label('From date')
                    ->native(false)
                    ->displayFormat('M j, Y')
                    ->maxDate(now()),
                DatePicker::make('to')
                    ->label('To date')
                    ->native(false)
                    ->displayFormat('M j, Y')
                    ->maxDate(now())
                    ->afterOrEqual('from'),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function applyFilter(): void
    {
        $this->form->getState();
    }

    public function clearFilter(): void
    {
        $this->form->fill([
            'from' => null,
            'to' => null,
        ]);
    }

    public function setPreset(string $preset): void
    {
        $today = Carbon::today();

        [$from, $to] = match ($preset) {
            'today' => [$today->toDateString(), $today->toDateString()],
            'yesterday' => [
                Carbon::yesterday()->toDateString(),
                Carbon::yesterday()->toDateString(),
            ],
            'week' => [
                $today->copy()->startOfWeek()->toDateString(),
                $today->toDateString(),
            ],
            'month' => [
                $today->copy()->startOfMonth()->toDateString(),
                $today->toDateString(),
            ],
            'year' => [
                $today->copy()->startOfYear()->toDateString(),
                $today->toDateString(),
            ],
            default => [null, null],
        };

        $this->form->fill([
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function getSummaryProperty(): array
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        return [
            'today' => ApplicationDownloadLog::query()->whereDate('created_at', $today)->count(),
            'yesterday' => ApplicationDownloadLog::query()->whereDate('created_at', $yesterday)->count(),
            'this_week' => ApplicationDownloadLog::query()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'this_month' => ApplicationDownloadLog::query()
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
            'this_year' => ApplicationDownloadLog::query()
                ->whereYear('created_at', (int) date('Y'))
                ->count(),
            'all_time' => ApplicationDownloadLog::query()->count(),
        ];
    }

    public function getRangeFromProperty(): ?Carbon
    {
        $from = $this->data['from'] ?? null;

        return $from ? Carbon::parse($from)->startOfDay() : null;
    }

    public function getRangeToProperty(): ?Carbon
    {
        $to = $this->data['to'] ?? null;

        return $to ? Carbon::parse($to)->endOfDay() : null;
    }

    public function getHasActiveFilterProperty(): bool
    {
        return filled($this->data['from'] ?? null) || filled($this->data['to'] ?? null);
    }

    public function getActivePresetProperty(): ?string
    {
        $from = $this->data['from'] ?? null;
        $to = $this->data['to'] ?? null;

        if (! $from && ! $to) {
            return 'all';
        }

        $today = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();
        $weekStart = Carbon::today()->startOfWeek()->toDateString();
        $monthStart = Carbon::today()->startOfMonth()->toDateString();
        $yearStart = Carbon::today()->startOfYear()->toDateString();

        return match (true) {
            $from === $today && $to === $today => 'today',
            $from === $yesterday && $to === $yesterday => 'yesterday',
            $from === $weekStart && $to === $today => 'week',
            $from === $monthStart && $to === $today => 'month',
            $from === $yearStart && $to === $today => 'year',
            default => null,
        };
    }

    public function getFilterLabelProperty(): string
    {
        if (! $this->hasActiveFilter) {
            return 'All time';
        }

        $from = $this->rangeFrom?->format('M j, Y') ?? 'Start';
        $to = $this->rangeTo?->format('M j, Y') ?? 'Now';

        return "{$from} – {$to}";
    }

    public function getFilteredCountProperty(): int
    {
        return ApplicationDownloadLog::query()
            ->betweenDates($this->rangeFrom, $this->rangeTo)
            ->count();
    }

    public function getDailyBreakdownProperty(): Collection
    {
        return ApplicationDownloadLog::query()
            ->betweenDates($this->rangeFrom, $this->rangeTo)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->orderByDesc('day')
            ->limit(60)
            ->get();
    }

    public function getMaxDailyTotalProperty(): int
    {
        return max(1, (int) $this->dailyBreakdown->max('total'));
    }

    public function getYearlyStatsProperty(): Collection
    {
        return ApplicationDownloadStat::query()
            ->orderByDesc('year')
            ->get();
    }

    public function getMaxYearlyTotalProperty(): int
    {
        return max(1, (int) $this->yearlyStats->max('downloads_count'));
    }

    public function getRecentDownloadsProperty(): Collection
    {
        return ApplicationDownloadLog::query()
            ->betweenDates($this->rangeFrom, $this->rangeTo)
            ->latest('created_at')
            ->limit(25)
            ->get();
    }

    public function getPeakDayProperty(): ?object
    {
        return $this->dailyBreakdown->sortByDesc('total')->first();
    }
}

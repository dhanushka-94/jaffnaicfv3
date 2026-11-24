<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Every festival year that has any content, newest first.
 *
 * Used by the site navigation and the sitemap. The result is cached briefly so the
 * layout does not run a dozen "SELECT DISTINCT year" queries on every page view.
 */
class ArchiveYears
{
    private const CACHE_KEY = 'site.archive_years';

    private const TTL_SECONDS = 600;

    /** @var list<class-string<\Illuminate\Database\Eloquent\Model>> */
    private const MODELS = [
        \App\Models\TeamMember::class,
        \App\Models\Partner::class,
        \App\Models\Venue::class,
        \App\Models\ScheduleImage::class,
        \App\Models\MasterclassImage::class,
        \App\Models\DebutFilmImage::class,
        \App\Models\JuryDebutImage::class,
        \App\Models\JuryShortImage::class,
        \App\Models\NationalShortImage::class,
        \App\Models\InternationalShortImage::class,
        \App\Models\NewAsianCurrentImage::class,
        \App\Models\JuryNewAsianCurrentImage::class,
    ];

    /** @return Collection<int, int> */
    public static function all(): Collection
    {
        try {
            $years = Cache::remember(self::CACHE_KEY, self::TTL_SECONDS, fn () => self::query()->all());
        } catch (\Throwable) {
            $years = self::query()->all();
        }

        return collect($years);
    }

    /** Years other than the current festival year. */
    public static function past(): Collection
    {
        $current = (int) date('Y');

        return self::all()->filter(fn (int $year) => $year !== $current)->values();
    }

    public static function forget(): void
    {
        try {
            Cache::forget(self::CACHE_KEY);
        } catch (\Throwable) {
            //
        }
    }

    /** @return Collection<int, int> */
    private static function query(): Collection
    {
        $years = collect();

        foreach (self::MODELS as $model) {
            try {
                $years = $years->merge($model::query()->select('year')->distinct()->pluck('year'));
            } catch (\Throwable) {
                // Table not migrated yet (fresh install): ignore.
            }
        }

        return $years
            ->filter()
            ->map(fn ($year) => (int) $year)
            ->unique()
            ->sortDesc()
            ->values();
    }
}
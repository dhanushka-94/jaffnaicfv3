<?php

namespace App\Http\Controllers;

use App\Models\DebutFilmImage;
use App\Models\InternationalShortImage;
use App\Models\JuryDebutImage;
use App\Models\JuryNewAsianCurrentImage;
use App\Models\JuryShortImage;
use App\Models\MasterclassImage;
use App\Models\NationalShortImage;
use App\Models\NewAsianCurrentImage;
use App\Models\News;
use App\Models\Partner;
use App\Models\ScheduleImage;
use App\Models\TeamMember;
use App\Models\Venue;
use App\Support\ArchiveYears;
use Carbon\CarbonInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SitemapController extends Controller
{
    /**
     * Programme pages: route suffix => model holding that page's content.
     *
     * @var array<string, class-string<\Illuminate\Database\Eloquent\Model>>
     */
    private const PROGRAMME = [
        'schedule' => ScheduleImage::class,
        'masterclasses' => MasterclassImage::class,
        'debut-films' => DebutFilmImage::class,
        'jury-debut-films' => JuryDebutImage::class,
        'jury-short-films' => JuryShortImage::class,
        'jury-new-asian-currents' => JuryNewAsianCurrentImage::class,
        'national-short-films' => NationalShortImage::class,
        'international-short-films' => InternationalShortImage::class,
        'new-asian-currents' => NewAsianCurrentImage::class,
    ];

    public function xml(): Response
    {
        try {
            $xml = Cache::remember('sitemap.xml.' . md5(url('/')), 3600, fn () => $this->buildXml());
        } catch (\Throwable) {
            $xml = $this->buildXml();
        }

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    private function buildXml(): string
    {
        $currentYear = (int) date('Y');
        $urls = [];

        $add = function (string $loc, ?CarbonInterface $lastmod, string $changefreq, string $priority) use (&$urls): void {
            $urls[$loc] = compact('loc', 'lastmod', 'changefreq', 'priority');
        };

        // Core pages
        $add(route('home'), null, 'weekly', '1.0');
        $add(route('about.jaffnaicf'), null, 'monthly', '0.8');
        $add(route('about.team'), $this->latest(TeamMember::class, $currentYear), 'monthly', '0.8');
        $add(route('venues'), $this->latest(Venue::class, $currentYear), 'monthly', '0.7');
        $add(route('partners'), $this->latest(Partner::class, $currentYear), 'monthly', '0.7');
        $add(route('gallery'), null, 'monthly', '0.6');
        $add(route('contact'), null, 'yearly', '0.6');

        // News
        $latestNews = News::query()->published()->max('updated_at');
        $add(route('news.index'), $latestNews ? \Illuminate\Support\Carbon::parse($latestNews) : null, 'weekly', '0.8');

        foreach (News::query()->published()->latest('published_at')->get() as $article) {
            $add(
                route('news.show', $article),
                $article->updated_at ?? $article->published_at,
                'monthly',
                '0.7'
            );
        }

        // Current edition programme pages
        foreach (self::PROGRAMME as $suffix => $model) {
            $add(route('programme.' . $suffix), $this->latest($model, $currentYear), 'weekly', '0.8');
        }

        // Archive: only pages that actually have content for that year
        foreach (ArchiveYears::past() as $year) {
            foreach (['team' => TeamMember::class, 'partners' => Partner::class, 'venues' => Venue::class] as $page => $model) {
                if ($this->hasContent($model, $year)) {
                    $add(route('archive.' . $page, $year), $this->latest($model, $year), 'yearly', '0.5');
                }
            }

            foreach (self::PROGRAMME as $suffix => $model) {
                if ($this->hasContent($model, $year)) {
                    $add(route('archive.programme.' . $suffix, $year), $this->latest($model, $year), 'yearly', '0.5');
                }
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";

            // Only advertise a modification date when we really know it.
            if ($u['lastmod']) {
                $xml .= '    <lastmod>' . $u['lastmod']->toAtomString() . "</lastmod>\n";
            }

            $xml .= '    <changefreq>' . $u['changefreq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $u['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        return $xml . '</urlset>' . "\n";
    }

    /** @param class-string<\Illuminate\Database\Eloquent\Model> $model */
    private function hasContent(string $model, int $year): bool
    {
        return $model::query()->where('year', $year)->exists();
    }

    /** @param class-string<\Illuminate\Database\Eloquent\Model> $model */
    private function latest(string $model, int $year): ?\Illuminate\Support\Carbon
    {
        $value = $model::query()->where('year', $year)->max('updated_at');

        return $value ? \Illuminate\Support\Carbon::parse($value) : null;
    }

    public function index(): View
    {
        return view('sitemap', [
            'currentYear' => (int) date('Y'),
            'pastYears' => ArchiveYears::past(),
        ]);
    }
}
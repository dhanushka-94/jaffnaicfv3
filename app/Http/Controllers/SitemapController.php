<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\Partner;
use App\Models\Venue;
use App\Models\ScheduleImage;
use App\Models\MasterclassImage;
use App\Models\DebutFilmImage;
use App\Models\JuryDebutImage;
use App\Models\JuryShortImage;
use App\Models\NationalShortImage;
use App\Models\InternationalShortImage;
use App\Models\NewAsianCurrentImage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class SitemapController extends Controller
{
    public function xml(): Response
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        $sitemap .= $this->urlTag(url('/'), now(), '1.0', 'daily');

        // Static pages
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0'],
            ['url' => route('about.team'), 'priority' => '0.8'],
            ['url' => route('partners'), 'priority' => '0.7'],
            ['url' => route('venues'), 'priority' => '0.7'],
            ['url' => route('contact'), 'priority' => '0.6'],
        ];

        foreach ($staticPages as $page) {
            $sitemap .= $this->urlTag($page['url'], now(), $page['priority'], 'monthly');
        }

        // Programme pages
        $programmePages = [
            route('programme.schedule'),
            route('programme.masterclasses'),
            route('programme.debut-films'),
            route('programme.jury-debut-films'),
            route('programme.jury-short-films'),
            route('programme.national-short-films'),
            route('programme.international-short-films'),
            route('programme.new-asian-currents'),
        ];

        foreach ($programmePages as $url) {
            $sitemap .= $this->urlTag($url, now(), '0.8', 'weekly');
        }

        // Archive pages
        $currentYear = (int) date('Y');
        $archiveYears = collect();
        $archiveYears = $archiveYears->merge(\App\Models\TeamMember::select('year')->distinct()->pluck('year'));
        $archiveYears = $archiveYears->merge(\App\Models\Partner::select('year')->distinct()->pluck('year'));
        $archiveYears = $archiveYears->merge(\App\Models\Venue::select('year')->distinct()->pluck('year'));
        $archiveYears = $archiveYears->unique()->sortDesc()->values();

        foreach ($archiveYears as $year) {
            if ($year != $currentYear) {
                $sitemap .= $this->urlTag(route('archive.team', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.partners', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.venues', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.programme.schedule', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.programme.masterclasses', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.programme.debut-films', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.programme.jury-debut-films', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.programme.jury-short-films', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.programme.national-short-films', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.programme.international-short-films', $year), now()->subYear(), '0.6', 'yearly');
                $sitemap .= $this->urlTag(route('archive.programme.new-asian-currents', $year), now()->subYear(), '0.6', 'yearly');
            }
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function urlTag(string $url, $lastmod, string $priority, string $changefreq): string
    {
        return "  <url>\n" .
               "    <loc>" . htmlspecialchars($url) . "</loc>\n" .
               "    <lastmod>" . $lastmod->format('Y-m-d') . "</lastmod>\n" .
               "    <changefreq>" . $changefreq . "</changefreq>\n" .
               "    <priority>" . $priority . "</priority>\n" .
               "  </url>\n";
    }

    public function index(): View
    {
        $currentYear = (int) date('Y');
        
        // Get available archive years
        $archiveYears = collect();
        $archiveYears = $archiveYears->merge(TeamMember::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(Partner::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(Venue::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(ScheduleImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(MasterclassImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(DebutFilmImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(JuryDebutImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(JuryShortImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(NationalShortImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(InternationalShortImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->merge(NewAsianCurrentImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $archiveYears = $archiveYears->unique()->sortDesc()->values();
        
        $pastYears = $archiveYears->filter(fn($y) => $y !== $currentYear)->values();

        return view('sitemap', [
            'currentYear' => $currentYear,
            'pastYears' => $pastYears,
        ]);
    }
}


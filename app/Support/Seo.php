<?php

namespace App\Support;

use Illuminate\Http\Request;

class Seo
{
    /** Programme page labels, keyed by the route name suffix. */
    private const PROGRAMME = [
        'schedule' => 'Schedule',
        'masterclasses' => 'Master Classes',
        'debut-films' => 'Debut Films in Competition',
        'jury-debut-films' => 'Jury – Debut Films',
        'jury-short-films' => 'Jury – Short Films',
        'jury-new-asian-currents' => 'Jury – New Asian Currents (Documentary)',
        'national-short-films' => 'National Short Films',
        'international-short-films' => 'International Short Films',
        'new-asian-currents' => 'New Asian Currents – Documentary',
    ];

    private const PAGES = [
        'about.jaffnaicf' => 'JAFFNAICF',
        'about.team' => 'Team',
        'venues' => 'Venues',
        'partners' => 'Partners',
        'gallery' => 'Image Gallery',
        'news.index' => 'News',
        'contact' => 'Contact',
        'sitemap' => 'Sitemap',
    ];

    /**
     * Breadcrumb trail for the current request: list of [name, url|null].
     * The last item is the current page.
     *
     * @return list<array{0: string, 1: ?string}>
     */
    public static function trail(Request $request, ?string $currentTitle = null): array
    {
        $name = (string) $request->route()?->getName();
        $trail = [['Home', route('home')]];

        if ($name === '' || $name === 'home') {
            return [];
        }

        if (isset(self::PAGES[$name])) {
            $trail[] = [self::PAGES[$name], url()->current()];
        } elseif ($name === 'news.show') {
            $trail[] = ['News', route('news.index')];
            $trail[] = [$currentTitle ?: 'Article', url()->current()];
        } elseif (str_starts_with($name, 'programme.')) {
            $key = substr($name, strlen('programme.'));
            $trail[] = ['Programme', null];
            $trail[] = [self::PROGRAMME[$key] ?? ucfirst($key), url()->current()];
        } elseif (str_starts_with($name, 'archive.')) {
            $year = (string) $request->route('year');
            $trail[] = ['Archive', route('archive.index')];

            if ($year !== '') {
                $trail[] = [$year, route('archive.year', $year)];
            }

            $key = substr($name, strlen('archive.'));

            if ($key === 'team') {
                $trail[] = ['Team', url()->current()];
            } elseif (in_array($key, ['partners', 'venues'], true)) {
                $trail[] = [ucfirst($key), url()->current()];
            } elseif (str_starts_with($key, 'programme.')) {
                $page = substr($key, strlen('programme.'));
                $trail[] = [self::PROGRAMME[$page] ?? ucfirst($page), url()->current()];
            }
        } else {
            return [];
        }

        return $trail;
    }

    /**
     * schema.org BreadcrumbList for the current request (null on the home page).
     */
    public static function breadcrumbSchema(Request $request, ?string $currentTitle = null): ?array
    {
        $trail = self::trail($request, $currentTitle);

        if (count($trail) < 2) {
            return null;
        }

        $items = [];
        $position = 1;

        foreach ($trail as [$label, $url]) {
            $item = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $label,
            ];

            if ($url) {
                $item['item'] = $url;
            }

            $items[] = $item;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }
}
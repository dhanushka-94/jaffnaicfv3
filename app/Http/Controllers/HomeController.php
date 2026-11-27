<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\FilmStripImage;
use App\Models\News;
use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Models\Review;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $currentYear = (int) date('Y');
        $featuredFilms = Film::query()->where('is_featured', true)->latest()->take(8)->get();
        $partnerGroups = PartnerCategory::query()
            ->with(['partners' => function ($query) use ($currentYear) {
                $query->where('year', $currentYear)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn (PartnerCategory $category) => $category->partners->isNotEmpty())
            ->map(fn (PartnerCategory $category) => [
                'name' => $category->name,
                'partners' => $category->partners,
            ])
            ->values();

        $uncategorizedPartners = Partner::query()
            ->where('year', $currentYear)
            ->whereNull('category_id')
            ->orderBy('sort_order')
            ->get();

        if ($uncategorizedPartners->isNotEmpty()) {
            $partnerGroups->push([
                'name' => $partnerGroups->isNotEmpty() ? 'Partners' : null,
                'partners' => $uncategorizedPartners,
            ]);
        }
        $sliders = Slider::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $reviews = Review::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $latestNews = News::query()
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        $filmStrip = $this->filmStrip();

        return view('home', compact('featuredFilms', 'partnerGroups', 'sliders', 'currentYear', 'reviews', 'latestNews', 'filmStrip'));
    }

    /**
     * @return list<array{src: string, alt: string}>
     */
    private function filmStrip(): array
    {
        $items = [];

        FilmStripImage::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->each(function (FilmStripImage $image) use (&$items): void {
                if (blank($image->image_path) || ! Storage::disk('public')->exists($image->image_path)) {
                    return;
                }

                $items[] = [
                    'src' => asset('storage/'.$image->image_path),
                    'alt' => filled($image->title) ? $image->title : 'Festival photograph',
                ];
            });

        $base = $items;

        if ($base === []) {
            return [];
        }

        $loop = $base;

        while (count($loop) < 12) {
            $loop = array_merge($loop, $base);
        }

        return $loop;
    }
}



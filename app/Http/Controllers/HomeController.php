<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\FilmStripImage;
use App\Models\News;
use App\Models\Partner;
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
        $partners = Partner::query()
            ->where('year', $currentYear)
            ->orderBy('sort_order')
            ->take(12)
            ->get();
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

        return view('home', compact('featuredFilms', 'partners', 'sliders', 'currentYear', 'reviews', 'latestNews', 'filmStrip'));
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



<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Partner;
use App\Models\Review;
use App\Models\Slider;
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

        return view('home', compact('featuredFilms', 'partners', 'sliders', 'currentYear', 'reviews'));
    }
}



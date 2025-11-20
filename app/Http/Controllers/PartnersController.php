<?php

namespace App\Http\Controllers;

use App\Models\PartnerCategory;
use App\Models\SectionSetting;
use Illuminate\View\View;

class PartnersController extends Controller
{
    public function index(): View
    {
        $isActive = SectionSetting::where('key', 'partners')->value('is_active') ?? true;

        if (! $isActive) {
            return view('partners', [
                'inactive' => true,
                'categories' => collect(),
            ]);
        }

        $currentYear = (int) date('Y');
        $categories = PartnerCategory::with(['partners' => function ($query) use ($currentYear) {
            $query->where('year', $currentYear)->orderBy('sort_order');
        }])->orderBy('sort_order')->get();

        return view('partners', [
            'categories' => $categories,
        ]);
    }
}

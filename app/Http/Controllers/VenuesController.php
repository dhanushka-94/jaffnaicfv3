<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\SectionSetting;
use Illuminate\View\View;

class VenuesController extends Controller
{
    public function index(): View
    {
        $isActive = SectionSetting::where('key', 'venues')->value('is_active') ?? true;

        if (! $isActive) {
            return view('venues', [
                'inactive' => true,
                'venues' => collect(),
            ]);
        }

        $currentYear = (int) date('Y');
        $venues = Venue::query()
            ->where('year', $currentYear)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('venues', compact('venues'));
    }
}



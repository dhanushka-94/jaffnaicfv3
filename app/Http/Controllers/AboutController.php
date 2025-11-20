<?php

namespace App\Http\Controllers;

use App\Models\AboutJaffnaicfImage;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function jaffnaicf(): View
    {
        $images = AboutJaffnaicfImage::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('about.jaffnaicf', [
            'images' => $images,
        ]);
    }
}

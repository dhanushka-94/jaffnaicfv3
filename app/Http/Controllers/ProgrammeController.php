<?php

namespace App\Http\Controllers;

use App\Models\DebutFilmImage;
use App\Models\InternationalShortImage;
use App\Models\JuryDebutImage;
use App\Models\JuryShortImage;
use App\Models\MasterclassImage;
use App\Models\NationalShortImage;
use App\Models\NewAsianCurrentImage;
use App\Models\ScheduleImage;
use App\Models\SectionSetting;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProgrammeController extends Controller
{
    protected function isActive(string $key): bool
    {
        return (bool) (SectionSetting::where('key', $key)->value('is_active') ?? true);
    }

    protected function currentYear(): int
    {
        return (int) date('Y');
    }

    public function schedule(): View
    {
        $year = $this->currentYear();
        $active = $this->isActive('programme_schedule');
        $images = $active
            ? ScheduleImage::where('year', $year)->orderBy('sort_order')->get()
            : collect();

        return view('programme.schedule', compact('year', 'active', 'images'));
    }

    public function masterclasses(): View
    {
        $year = $this->currentYear();
        $active = $this->isActive('programme_masterclasses');
        $images = $active
            ? MasterclassImage::where('year', $year)->orderBy('sort_order')->get()
            : collect();

        return view('programme.masterclasses', compact('year', 'active', 'images'));
    }

    public function debutFilms(): View
    {
        $year = $this->currentYear();
        $active = $this->isActive('programme_debut_films');
        $images = $active
            ? DebutFilmImage::where('year', $year)->orderBy('sort_order')->get()
            : collect();

        return view('programme.debut-films', compact('year', 'active', 'images'));
    }

    public function juryDebut(): View
    {
        $year = $this->currentYear();
        $active = $this->isActive('programme_jury_debut');
        $images = $active
            ? JuryDebutImage::where('year', $year)->orderBy('sort_order')->get()
            : collect();

        return view('programme.jury-debut', compact('year', 'active', 'images'));
    }

    public function juryShort(): View
    {
        $year = $this->currentYear();
        $active = $this->isActive('programme_jury_short');
        $images = $active
            ? JuryShortImage::where('year', $year)->orderBy('sort_order')->get()
            : collect();

        return view('programme.jury-short', compact('year', 'active', 'images'));
    }

    public function nationalShorts(): View
    {
        $year = $this->currentYear();
        $active = $this->isActive('programme_national_shorts');
        $images = $active
            ? NationalShortImage::where('year', $year)->orderBy('sort_order')->get()
            : collect();

        return view('programme.national-shorts', compact('year', 'active', 'images'));
    }

    public function internationalShorts(): View
    {
        $year = $this->currentYear();
        $active = $this->isActive('programme_international_shorts');
        $images = $active
            ? InternationalShortImage::where('year', $year)->orderBy('sort_order')->get()
            : collect();

        return view('programme.international-shorts', compact('year', 'active', 'images'));
    }

    public function newAsianCurrents(): View
    {
        $year = $this->currentYear();
        $active = $this->isActive('programme_new_asian_currents');
        $images = $active
            ? NewAsianCurrentImage::where('year', $year)->orderBy('sort_order')->get()
            : collect();

        return view('programme.new-asian-currents', compact('year', 'active', 'images'));
    }
}



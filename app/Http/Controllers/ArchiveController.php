<?php

namespace App\Http\Controllers;

use App\Models\DebutFilmImage;
use App\Models\InternationalShortImage;
use App\Models\JuryDebutImage;
use App\Models\JuryShortImage;
use App\Models\MasterclassImage;
use App\Models\NationalShortImage;
use App\Models\NewAsianCurrentImage;
use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Models\ScheduleImage;
use App\Models\SectionSetting;
use App\Models\TeamMember;
use App\Models\Venue;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    protected function getAvailableYears(): array
    {
        $years = collect();
        
        // Get years from all content types and ensure they are integers
        $years = $years->merge(TeamMember::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(Partner::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(Venue::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(ScheduleImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(MasterclassImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(DebutFilmImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(JuryDebutImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(JuryShortImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(NationalShortImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(InternationalShortImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        $years = $years->merge(NewAsianCurrentImage::select('year')->distinct()->pluck('year')->map(fn($y) => (int) $y));
        
        return $years->unique()->sortDesc()->values()->toArray();
    }

    public function index(?int $year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year ?? $currentYear;
        $availableYears = $this->getAvailableYears();
        
        // If selected year is current year, redirect to main pages
        if ($selectedYear === $currentYear) {
            return redirect()->route('home');
        }

        return view('archive.index', [
            'year' => $selectedYear,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
        ]);
    }

    public function team($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();

        $isActive = SectionSetting::where('key', 'team_members')->value('is_active') ?? true;

        if (! $isActive && $selectedYear === $currentYear) {
            return view('team', [
                'inactive' => true,
                'groups' => collect(),
                'roleOrder' => [],
                'year' => $selectedYear,
                'availableYears' => $availableYears,
            ]);
        }

        // Query that handles both integer and string year values in database
        // Use CAST to ensure proper integer comparison regardless of storage type
        $all = TeamMember::query()
            ->where(function ($query) use ($selectedYear) {
                $query->where('year', (int) $selectedYear)
                      ->orWhere('year', (string) $selectedYear)
                      ->orWhereRaw('CAST(year AS UNSIGNED) = ?', [(int) $selectedYear]);
            })
            ->orderBy('sort_order')
            ->get()
            ->groupBy('role');

        $roleOrder = [
            'Director' => 'FESTIVAL DIRECTOR',
            'Consultant' => 'PROGRAMME CONSULTANTS',
            'Advisory Committee' => 'ADVISORY COMMITTEE',
            'Manager' => 'FESTIVAL MANAGER',
            'Coordinator — Colombo' => 'COORDINATOR – COLOMBO',
            'Coordinator — Jaffna' => 'COORDINATOR – JAFFNA',
            'Festival Team' => 'FESTIVAL TEAM',
            'Design & Illustrations' => 'DESIGN & ILLUSTRATIONS',
            'Printers' => 'PRINTERS',
        ];

        return view('archive.team', [
            'groups' => $all,
            'roleOrder' => $roleOrder,
            'year' => $selectedYear,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function partners($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();

        $isActive = SectionSetting::where('key', 'partners')->value('is_active') ?? true;

        if (! $isActive && $selectedYear === $currentYear) {
            return view('partners', [
                'inactive' => true,
                'categories' => collect(),
                'year' => $selectedYear,
                'availableYears' => $availableYears,
            ]);
        }

        $categories = PartnerCategory::with(['partners' => function ($query) use ($selectedYear) {
            $query->where('year', (int) $selectedYear)->orderBy('sort_order');
        }])->orderBy('sort_order')->get();

        return view('archive.partners', [
            'categories' => $categories,
            'year' => $selectedYear,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function venues($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();

        $isActive = SectionSetting::where('key', 'venues')->value('is_active') ?? true;

        if (! $isActive && $selectedYear === $currentYear) {
            return view('venues', [
                'inactive' => true,
                'venues' => collect(),
                'year' => $selectedYear,
                'availableYears' => $availableYears,
            ]);
        }

        $venues = Venue::query()
            ->where('year', (int) $selectedYear)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('archive.venues', [
            'venues' => $venues,
            'year' => $selectedYear,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function schedule($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();
        $active = $this->isActive('programme_schedule');
        $images = $active
            ? ScheduleImage::where('year', (int) $selectedYear)->orderBy('sort_order')->get()
            : collect();

        return view('archive.programme.schedule', [
            'year' => $selectedYear,
            'active' => $active,
            'images' => $images,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function masterclasses($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();
        $active = $this->isActive('programme_masterclasses');
        $images = $active
            ? MasterclassImage::where('year', (int) $selectedYear)->orderBy('sort_order')->get()
            : collect();

        return view('archive.programme.masterclasses', [
            'year' => $selectedYear,
            'active' => $active,
            'images' => $images,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function debutFilms($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();
        $active = $this->isActive('programme_debut_films');
        $images = $active
            ? DebutFilmImage::where('year', (int) $selectedYear)->orderBy('sort_order')->get()
            : collect();

        return view('archive.programme.debut-films', [
            'year' => $selectedYear,
            'active' => $active,
            'images' => $images,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function juryDebut($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();
        $active = $this->isActive('programme_jury_debut');
        $images = $active
            ? JuryDebutImage::where('year', (int) $selectedYear)->orderBy('sort_order')->get()
            : collect();

        return view('archive.programme.jury-debut', [
            'year' => $selectedYear,
            'active' => $active,
            'images' => $images,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function juryShort($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();
        $active = $this->isActive('programme_jury_short');
        $images = $active
            ? JuryShortImage::where('year', (int) $selectedYear)->orderBy('sort_order')->get()
            : collect();

        return view('archive.programme.jury-short', [
            'year' => $selectedYear,
            'active' => $active,
            'images' => $images,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function nationalShorts($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();
        $active = $this->isActive('programme_national_shorts');
        $images = $active
            ? NationalShortImage::where('year', (int) $selectedYear)->orderBy('sort_order')->get()
            : collect();

        return view('archive.programme.national-shorts', [
            'year' => $selectedYear,
            'active' => $active,
            'images' => $images,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function internationalShorts($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();
        $active = $this->isActive('programme_international_shorts');
        $images = $active
            ? InternationalShortImage::where('year', (int) $selectedYear)->orderBy('sort_order')->get()
            : collect();

        return view('archive.programme.international-shorts', [
            'year' => $selectedYear,
            'active' => $active,
            'images' => $images,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    public function newAsianCurrents($year = null): View
    {
        $currentYear = (int) date('Y');
        $selectedYear = $year !== null ? (int) $year : $currentYear;
        $availableYears = $this->getAvailableYears();
        $active = $this->isActive('programme_new_asian_currents');
        $images = $active
            ? NewAsianCurrentImage::where('year', (int) $selectedYear)->orderBy('sort_order')->get()
            : collect();

        return view('archive.programme.new-asian-currents', [
            'year' => $selectedYear,
            'active' => $active,
            'images' => $images,
            'availableYears' => $availableYears,
            'currentYear' => $currentYear,
            'isArchive' => $selectedYear !== $currentYear,
        ]);
    }

    protected function isActive(string $key): bool
    {
        return (bool) (SectionSetting::where('key', $key)->value('is_active') ?? true);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\SectionSetting;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $isActive = SectionSetting::where('key', 'team_members')->value('is_active') ?? true;

        if (! $isActive) {
            return view('team', [
                'inactive' => true,
                'groups' => collect(),
                'roleOrder' => [],
            ]);
        }

        $currentYear = (int) date('Y');
        $all = TeamMember::query()
            ->where('year', $currentYear)
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

        return view('team', [
            'groups' => $all,
            'roleOrder' => $roleOrder,
        ]);
    }
}



<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact', [
            'contacts' => $this->festivalContacts(),
        ]);
    }

    /**
     * Festival Director and Festival Manager, taken from the Team Members records
     * for the current year. Falls back to the defaults if a record is missing.
     *
     * @return array<int, array{title: string, name: string, email: ?string, phone: ?string}>
     */
    protected function festivalContacts(): array
    {
        $defaults = [
            'Director' => [
                'title' => 'Festival Director',
                'name' => 'Anomaa Rajakaruna',
                'email' => 'anomaaraj@gmail.com',
                'phone' => '+94 77 787 9911',
            ],
            'Manager' => [
                'title' => 'Festival Manager',
                'name' => 'Rishi Selvam',
                'email' => 'rishi.murgi@gmail.com',
                'phone' => '+94 77 515 4830',
            ],
        ];

        $records = collect();

        if (Schema::hasTable('team_members')) {
            $records = TeamMember::query()
                ->where('year', (int) date('Y'))
                ->whereIn('role', array_keys($defaults))
                ->orderBy('sort_order')
                ->get()
                ->unique('role')
                ->keyBy('role');
        }

        $contacts = [];

        foreach ($defaults as $role => $fallback) {
            $record = $records->get($role);

            $contacts[] = $record
                ? [
                    'title' => $fallback['title'],
                    'name' => $record->name,
                    'email' => $record->email,
                    'phone' => $record->phone,
                ]
                : $fallback;
        }

        return $contacts;
    }
}
<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            // FESTIVAL DIRECTOR
            ['name' => 'Anomaa Rajakaruna', 'role' => 'Director'],

            // PROGRAMME CONSULTANTS
            ['name' => 'Prof. T. Sanathanan', 'role' => 'Consultant'],
            ['name' => 'Premendra Mazumder', 'role' => 'Consultant'],
            ['name' => 'Joao Paulo Macedo', 'role' => 'Consultant'],
            ['name' => 'Dr. Rwita Dutta', 'role' => 'Consultant'],

            // ADVISORY COMMITTEE
            ['name' => 'Dr. Packiyanathan Ahilan', 'role' => 'Advisory Committee'],
            ['name' => 'Jeeva Perumalpillai – Essex', 'role' => 'Advisory Committee'],
            ['name' => 'Dr. Navadharshani Karunaharan', 'role' => 'Advisory Committee'],
            ['name' => 'Saminadan Wimal', 'role' => 'Advisory Committee'],
            ['name' => 'Aingkaran Kugathasan', 'role' => 'Advisory Committee'],
            ['name' => 'Aruna Gunarathna', 'role' => 'Advisory Committee'],
            ['name' => 'Thambiayah Thevathasan', 'role' => 'Advisory Committee'],
            ['name' => 'Kanapathi Pillai Sarvananda', 'role' => 'Advisory Committee'],
            ['name' => 'J. M. K. Nicholas', 'role' => 'Advisory Committee'],

            // FESTIVAL MANAGER
            ['name' => 'Kanaka Abeygunawardana', 'role' => 'Manager'],

            // COORDINATORS
            ['name' => 'Dinuki Panditharatne', 'role' => 'Coordinator — Colombo'],
            ['name' => 'Rishi Selvam', 'role' => 'Coordinator — Jaffna'],

            // FESTIVAL TEAM
            ['name' => 'Mervyn Besley', 'role' => 'Festival Team'],
            ['name' => 'Sulochana Pieris', 'role' => 'Festival Team'],
            ['name' => 'Raj Sivaraj', 'role' => 'Festival Team'],
            ['name' => 'Sasanka Sanjeewa Abeykoon', 'role' => 'Festival Team'],
            ['name' => 'Rahul Ratnayake', 'role' => 'Festival Team'],
            ['name' => 'Thushitha Sivagurunathan', 'role' => 'Festival Team'],
            ['name' => 'Dimon John', 'role' => 'Festival Team'],
            ['name' => 'Peter Xavier Calis', 'role' => 'Festival Team'],

            // DESIGN & ILLUSTRATIONS
            ['name' => 'Sameera Weerasekera', 'role' => 'Design & Illustrations'],

            // PRINTERS
            ['name' => 'Amin8', 'role' => 'Printers'],
        ];

        $order = 1;
        foreach ($members as $m) {
            TeamMember::query()->updateOrCreate(
                ['name' => $m['name']],
                [
                    'role' => $m['role'],
                    'sort_order' => $order++,
                ]
            );
        }
    }
}



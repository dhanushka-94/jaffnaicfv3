<?php

namespace Database\Seeders;

use App\Models\SectionSetting;
use Illuminate\Database\Seeder;

class SectionSettingSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['key' => 'programme_schedule', 'label' => 'Programme — Schedule'],
            ['key' => 'programme_masterclasses', 'label' => 'Programme — Masterclasses'],
            ['key' => 'programme_debut_films', 'label' => 'Programme — Debut Films'],
            ['key' => 'programme_jury_debut', 'label' => 'Programme — Jury – Debut Films'],
            ['key' => 'programme_jury_short', 'label' => 'Programme — Jury – Short Films'],
            ['key' => 'programme_national_shorts', 'label' => 'Programme — National Short Films'],
            ['key' => 'programme_international_shorts', 'label' => 'Programme — International Short Films'],
            ['key' => 'programme_new_asian_currents', 'label' => 'Programme — New Asian Currents'],
            ['key' => 'programme_images', 'label' => 'Programme — General Images'],
            ['key' => 'team_members', 'label' => 'Team Members'],
            ['key' => 'venues', 'label' => 'Venues'],
            ['key' => 'partners', 'label' => 'Partners'],
        ];

        foreach ($sections as $data) {
            SectionSetting::updateOrCreate(
                ['key' => $data['key']],
                ['label' => $data['label'], 'is_active' => true],
            );
        }
    }
}



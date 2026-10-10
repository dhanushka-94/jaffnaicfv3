<?php

namespace Database\Seeders;

use App\Models\SectionSetting;
use Illuminate\Database\Seeder;

class SectionSettingSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SectionSetting::definitions() as $key => $label) {
            SectionSetting::query()->firstOrCreate(
                ['key' => $key],
                ['label' => $label, 'is_active' => true],
            );
        }
    }
}



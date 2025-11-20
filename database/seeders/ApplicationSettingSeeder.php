<?php

namespace Database\Seeders;

use App\Models\ApplicationSetting;
use Illuminate\Database\Seeder;

class ApplicationSettingSeeder extends Seeder
{
    public function run(): void
    {
        ApplicationSetting::query()->firstOrCreate([], [
            'application_open' => false,
            'application_pdf_path' => null,
        ]);
    }
}



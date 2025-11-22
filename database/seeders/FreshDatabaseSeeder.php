<?php

namespace Database\Seeders;

use App\Models\ApplicationSetting;
use App\Models\SectionSetting;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class FreshDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // List of all tables to truncate (excluding Laravel system tables)
        $tables = [
            'categories',
            'films',
            'venues',
            'schedules',
            'jury_members',
            'masterclasses',
            'news',
            'partners',
            'team_members',
            'archives',
            'contact_messages',
            'downloads',
            'site_settings',
            'sliders',
            'application_settings',
            'programme_images',
            'schedule_images',
            'masterclass_images',
            'debut_film_images',
            'jury_debut_images',
            'jury_short_images',
            'national_short_images',
            'international_short_images',
            'new_asian_current_images',
            'section_settings',
            'partner_categories',
            'gallery_images',
            'about_jaffnaicf_images',
            'reviews',
            'users',
        ];

        // Truncate all tables
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->command->info("Truncated table: {$table}");
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Create essential settings
        SiteSetting::firstOrCreate([], [
            'site_name' => 'JAFFNA ICF',
            'logo_path' => null,
        ]);

        ApplicationSetting::firstOrCreate([], [
            'application_open' => false,
            'application_pdf_path' => null,
        ]);

        // Create section settings with default inactive state
        $sections = [
            'team_members',
            'venues',
            'partners',
            'schedule',
            'masterclasses',
            'debut_films',
            'jury_debut_films',
            'jury_short_films',
            'national_short_films',
            'international_short_films',
            'new_asian_currents',
            'programme_images',
        ];

        foreach ($sections as $section) {
            SectionSetting::firstOrCreate(
                ['key' => $section],
                ['is_active' => false]
            );
        }

        $this->command->info('✓ Database cleared successfully!');
        $this->command->info('✓ Admin user created!');
        $this->command->info('✓ Essential settings created!');
        $this->command->newLine();
        $this->command->info('Admin Login Credentials:');
        $this->command->info('  Email: admin@admin.com');
        $this->command->info('  Password: admin123');
        $this->command->warn('⚠️  Please change the password after first login!');
    }
}


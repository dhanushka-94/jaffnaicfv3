<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Festival team for 2025 (archive) and 2026 (current). Safe to re-run:
     * a person is only inserted if the same role, name and year do not exist.
     */
    public function up(): void
    {
        if (! Schema::hasTable('team_members')) {
            return;
        }

        $people = [
            ['Director', 'Anomaa Rajakaruna', 'anomaaraj@gmail.com', '+94 77 787 9911'],
            ['Consultant', 'Prof. T. Sanathanan', null, null],
            ['Consultant', 'Premendra Mazumder', null, null],
            ['Consultant', 'Joao Paulo Macedo', null, null],
            ['Consultant', 'Dr. Rwita Dutta', null, null],
            ['Advisory Committee', 'Dr. Packiyanathan Ahilan', null, null],
            ['Advisory Committee', 'Jeeva Perumalpillai – Essex', null, null],
            ['Advisory Committee', 'Dr. Navadharshani Karunaharan', null, null],
            ['Advisory Committee', 'Saminadan Wimal', null, null],
            ['Advisory Committee', 'Aingkaran Kugathasan', null, null],
            ['Advisory Committee', 'Aruna Gunarathna', null, null],
            ['Advisory Committee', 'Thambiayah Thevathasan', null, null],
            ['Advisory Committee', 'Kanapathi Pillai Sarvananda', null, null],
            ['Advisory Committee', 'J. M. K. Nicholas', null, null],
            ['Manager', 'Rishi Selvam', 'rishi.murgi@gmail.com', '+94 77 515 4830'],
            ['Coordinator — Colombo', 'Dinuki Panditharatne', null, null],
            ['Coordinator — Jaffna', 'Jeyanthan Wichramasingam', null, null],
            ['Festival Team', 'Kanaka Abeygunawardana', null, null],
            ['Festival Team', 'Yoshitha Perera', null, null],
            ['Festival Team', 'Soba Koliyawanshe', null, null],
            ['Festival Team', 'Yamini Umapathy', null, null],
            ['Design & Illustrations', 'Sameera Weerasekera', null, null],
            ['Printers', 'Anim8', null, null],
        ];

        $now = now();

        foreach ([2025, 2026] as $year) {
            foreach ($people as $index => [$role, $name, $email, $phone]) {
                $exists = DB::table('team_members')
                    ->where('year', $year)
                    ->where('role', $role)
                    ->where('name', $name)
                    ->exists();

                if ($exists) {
                    continue;
                }

                DB::table('team_members')->insert([
                    'year' => $year,
                    'role' => $role,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'sort_order' => $index + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // Show the Team section on the public site so the 2026 team is visible.
        if (Schema::hasTable('section_settings')) {
            DB::table('section_settings')->updateOrInsert(
                ['key' => 'team_members'],
                ['label' => 'Team Members', 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }
    }

    public function down(): void
    {
        // Team content is editable in the admin; do not delete it on rollback.
    }
};
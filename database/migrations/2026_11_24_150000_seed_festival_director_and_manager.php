<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('team_members')) {
            return;
        }

        $year = (int) date('Y');
        $now = now();

        $people = [
            [
                'role' => 'Director',
                'name' => 'Anomaa Rajakaruna',
                'email' => 'anomaaraj@gmail.com',
                'phone' => '+94 77 787 9911',
                'sort_order' => 1,
            ],
            [
                'role' => 'Manager',
                'name' => 'Rishi Selvam',
                'email' => 'rishi.murgi@gmail.com',
                'phone' => '+94 77 515 4830',
                'sort_order' => 2,
            ],
        ];

        foreach ($people as $person) {
            $exists = DB::table('team_members')
                ->where('role', $person['role'])
                ->where('year', $year)
                ->exists();

            if (! $exists) {
                DB::table('team_members')->insert($person + [
                    'year' => $year,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Keep the records: they are editable content once created.
    }
};
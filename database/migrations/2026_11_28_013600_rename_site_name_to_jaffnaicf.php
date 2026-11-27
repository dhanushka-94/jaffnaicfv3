<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')
            ->whereIn('site_name', ['Jaffna ICF', 'JAFFNA ICF'])
            ->update(['site_name' => 'JaffnaICF']);
    }

    public function down(): void
    {
        DB::table('site_settings')
            ->where('site_name', 'JaffnaICF')
            ->update(['site_name' => 'Jaffna ICF']);
    }
};

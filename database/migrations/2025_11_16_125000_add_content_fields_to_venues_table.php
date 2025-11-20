<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->text('contacts')->nullable()->after('address');
            $table->longText('map_iframe')->nullable()->after('contacts');
            $table->unsignedInteger('sort_order')->default(0)->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn(['contacts', 'map_iframe', 'sort_order']);
        });
    }
};



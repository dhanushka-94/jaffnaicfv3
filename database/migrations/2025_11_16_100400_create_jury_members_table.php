<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jury_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable(); // e.g., Chair, Member
            $table->string('jury_type')->nullable(); // Debut Films, Short Films
            $table->string('photo_path')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jury_members');
    }
};



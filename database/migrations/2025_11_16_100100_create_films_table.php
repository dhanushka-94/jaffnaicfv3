<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->year('year')->nullable();
            $table->string('director')->nullable();
            $table->string('country')->nullable();
            $table->string('runtime')->nullable(); // e.g., "98 min"
            $table->string('poster_path')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};



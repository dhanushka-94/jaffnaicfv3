<?php

use App\Models\DebutFilmImage;
use App\Models\GalleryImage;
use App\Models\InternationalShortImage;
use App\Models\JuryDebutImage;
use App\Models\JuryShortImage;
use App\Models\MasterclassImage;
use App\Models\NationalShortImage;
use App\Models\NewAsianCurrentImage;
use App\Models\ProgrammeImage;
use App\Models\ScheduleImage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('film_strip_images', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image_path');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $this->copyExistingImages();
    }

    public function down(): void
    {
        Schema::dropIfExists('film_strip_images');
    }

    private function copyExistingImages(): void
    {
        $order = 0;
        $seen = [];

        $insert = function (?string $path, string $title) use (&$order, &$seen): void {
            if (blank($path) || isset($seen[$path]) || ! Storage::disk('public')->exists($path)) {
                return;
            }

            $seen[$path] = true;

            DB::table('film_strip_images')->insert([
                'title' => $title,
                'image_path' => $path,
                'is_active' => true,
                'sort_order' => $order,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $order++;
        };

        GalleryImage::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->each(function (GalleryImage $image) use ($insert): void {
                $title = filled($image->title) ? $image->title : 'Festival gallery';

                foreach ($image->getAllImagePaths() as $path) {
                    $insert($path, $title);
                }
            });

        foreach ([
            ScheduleImage::class => 'Festival schedule',
            MasterclassImage::class => 'Masterclass',
            DebutFilmImage::class => 'Debut film',
            JuryDebutImage::class => 'Debut film jury',
            JuryShortImage::class => 'Short film jury',
            NationalShortImage::class => 'National short film',
            InternationalShortImage::class => 'International short film',
            NewAsianCurrentImage::class => 'New Asian Currents',
            ProgrammeImage::class => 'Festival programme',
        ] as $class => $title) {
            $class::query()
                ->orderBy('sort_order')
                ->get()
                ->each(function ($image) use ($insert, $title): void {
                    $insert($image->image_path, $title);
                });
        }
    }
};

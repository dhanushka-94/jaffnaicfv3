<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'contacts',
        'map_iframe',
        'latitude',
        'longitude',
        'image_path',
        'description',
        'sort_order',
        'year',
    ];

    protected $casts = [
        'year' => 'integer',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Venue $venue) {
            if (empty($venue->slug) && ! empty($venue->name)) {
                $venue->slug = Str::slug($venue->name);
            }
        });
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function masterclasses(): HasMany
    {
        return $this->hasMany(Masterclass::class);
    }
}



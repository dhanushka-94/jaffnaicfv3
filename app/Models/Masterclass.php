<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Masterclass extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'speaker',
        'description',
        'date',
        'start_time',
        'end_time',
        'venue_id',
        'image_path',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}



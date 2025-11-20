<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebutFilmImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'image_path',
        'sort_order',
    ];
}



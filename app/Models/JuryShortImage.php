<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryShortImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'image_path',
        'sort_order',
    ];
}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'photo_path',
        'email',
        'phone',
        'bio',
        'sort_order',
        'year',
    ];

    protected $casts = [
        'year' => 'integer',
        'sort_order' => 'integer',
    ];
}



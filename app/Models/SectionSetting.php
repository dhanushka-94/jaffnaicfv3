<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'label',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** @return array<string, string> */
    public static function definitions(): array
    {
        return [
            'programme_schedule' => 'Programme — Schedule',
            'programme_masterclasses' => 'Programme — Masterclasses',
            'programme_debut_films' => 'Programme — Debut Films',
            'programme_jury_debut' => 'Programme — Jury – Debut Films',
            'programme_jury_short' => 'Programme — Jury – Short Films',
            'programme_national_shorts' => 'Programme — National Short Films',
            'programme_international_shorts' => 'Programme — International Short Films',
            'programme_new_asian_currents' => 'Programme — New Asian Currents',
            'programme_images' => 'Programme — General Images',
            'team_members' => 'Team Members',
            'venues' => 'Venues',
            'partners' => 'Partners',
        ];
    }
}



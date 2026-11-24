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

    /**
     * Roles in the order they appear on the public Team page.
     * Keys must match what the Team and Archive controllers group by.
     *
     * @return array<string, string>
     */
    public static function roleLabels(): array
    {
        return [
            'Director' => 'Festival Director',
            'Consultant' => 'Programme Consultants',
            'Advisory Committee' => 'Advisory Committee',
            'Manager' => 'Festival Manager',
            'Coordinator — Colombo' => 'Coordinator – Colombo',
            'Coordinator — Jaffna' => 'Coordinator – Jaffna',
            'Festival Team' => 'Festival Team',
            'Design & Illustrations' => 'Design & Illustrations',
            'Printers' => 'Printers',
        ];
    }
}

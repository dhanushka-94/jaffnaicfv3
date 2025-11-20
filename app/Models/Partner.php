<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo_path',
        'url',
        'category_id',
        'sort_order',
        'year',
    ];

    protected $casts = [
        'year' => 'integer',
        'sort_order' => 'integer',
        'category_id' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(PartnerCategory::class, 'category_id');
    }
}



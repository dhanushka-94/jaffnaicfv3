<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDownloadStat extends Model
{
    protected $fillable = [
        'year',
        'downloads_count',
    ];

    protected $casts = [
        'year' => 'integer',
        'downloads_count' => 'integer',
    ];

    public static function recordDownload(?int $year = null): void
    {
        $year = $year ?? (int) date('Y');

        $stat = static::query()->firstOrCreate(
            ['year' => $year],
            ['downloads_count' => 0],
        );

        $stat->increment('downloads_count');
    }
}

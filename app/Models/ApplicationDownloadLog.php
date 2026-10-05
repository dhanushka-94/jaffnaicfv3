<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ApplicationDownloadLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'year',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'created_at' => 'datetime',
    ];

    public static function record(?int $year = null): self
    {
        $year = $year ?? (int) date('Y');

        ApplicationDownloadStat::recordDownload($year);

        return static::query()->create([
            'year' => $year,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 500) ?: null,
            'created_at' => now(),
        ]);
    }

    public function scopeBetweenDates(Builder $query, ?Carbon $from, ?Carbon $to): Builder
    {
        if ($from) {
            $query->where('created_at', '>=', $from->copy()->startOfDay());
        }

        if ($to) {
            $query->where('created_at', '<=', $to->copy()->endOfDay());
        }

        return $query;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'feature_image_path',
        'excerpt',
        'content',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (News $news) {
            if (empty($news->slug) && ! empty($news->title)) {
                $base = Str::slug($news->title);
                $slug = $base;
                $i = 1;

                while (static::query()
                    ->where('slug', $slug)
                    ->when($news->exists, fn (Builder $q) => $q->whereKeyNot($news->getKey()))
                    ->exists()) {
                    $slug = $base.'-'.$i++;
                }

                $news->slug = $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->lte(now());
    }

    public function seoTitle(?string $siteName = null): string
    {
        $title = filled($this->meta_title) ? $this->meta_title : $this->title;
        $siteName = $siteName ?: 'Jaffna International Cinema Festival';

        return Str::limit($title.' — '.$siteName, 70, '');
    }

    public function seoDescription(): string
    {
        if (filled($this->meta_description)) {
            return Str::limit(trim($this->meta_description), 160, '');
        }

        if (filled($this->excerpt)) {
            return Str::limit(trim($this->excerpt), 160, '');
        }

        return Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($this->content ?? '')) ?? ''), 160, '');
    }

    public function seoImageUrl(): string
    {
        if (filled($this->feature_image_path)) {
            return asset('storage/'.$this->feature_image_path);
        }

        return asset('images/og-default.jpg');
    }

    public function seoKeywords(): ?string
    {
        return filled($this->meta_keywords) ? trim($this->meta_keywords) : null;
    }

    public function canonicalUrl(): string
    {
        return route('news.show', $this);
    }
}

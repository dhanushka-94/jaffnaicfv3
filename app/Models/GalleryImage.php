<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'image_paths',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'image_paths' => 'array',
    ];

    /**
     * Get all image paths (from image_paths array or single image_path)
     */
    public function getAllImagePaths(): array
    {
        if (!empty($this->image_paths) && is_array($this->image_paths)) {
            return $this->image_paths;
        }
        
        // Fallback to single image_path for backward compatibility
        if (!empty($this->image_path)) {
            return [$this->image_path];
        }
        
        return [];
    }
}

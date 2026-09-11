<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'points',
        'is_active',
    ];

    protected $casts = [
        'points' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the full URL for the image.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Storage::disk('public')->url($this->image);
    }
}

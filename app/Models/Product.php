<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_section_id',
        'name',
        'description',
        'benefit',
        'detail',
        'price',
        'image',
        'order',
    ];

    protected $touches = ['productSection'];

    public function productSection(): BelongsTo
    {
        return $this->belongsTo(ProductSection::class);
    }
}

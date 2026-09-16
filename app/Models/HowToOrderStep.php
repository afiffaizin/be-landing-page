<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowToOrderStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'how_to_order_section_id',
        'title',
        'description',
        'step_order',
    ];

    public function section(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(HowToOrderSection::class, 'how_to_order_section_id');
    }
}

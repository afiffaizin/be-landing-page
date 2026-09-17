<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HowToOrderStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'how_to_order_section_id',
        'title',
        'description',
        'step_order',
    ];

    protected $touches = ['section'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(HowToOrderSection::class, 'how_to_order_section_id');
    }
}

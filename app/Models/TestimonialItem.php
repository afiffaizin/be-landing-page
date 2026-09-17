<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialItem extends Model
{
    protected $fillable = ['testimonial_section_id', 'quote', 'name', 'subtitle'];

    protected $touches = ['testimonialSection'];

    public function testimonialSection()
    {
        return $this->belongsTo(TestimonialSection::class);
    }
}

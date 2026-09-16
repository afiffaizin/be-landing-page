<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialSection extends Model
{
    protected $fillable = ['title', 'is_active'];

    public function statistics()
    {
        return $this->hasMany(TestimonialStatistic::class);
    }

    public function testimonials()
    {
        return $this->hasMany(TestimonialItem::class);
    }
}

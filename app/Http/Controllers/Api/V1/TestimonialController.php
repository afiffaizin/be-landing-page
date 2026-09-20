<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialSectionResource;
use App\Models\TestimonialSection;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonialSection = TestimonialSection::with(['statistics', 'testimonials'])
            ->where('is_active', true)
            ->first();

        if (! $testimonialSection) {
            return response()->json(['data' => null]);
        }

        return new TestimonialSectionResource($testimonialSection);
    }
}

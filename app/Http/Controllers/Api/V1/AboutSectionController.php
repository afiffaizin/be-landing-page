<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutSectionResource;
use App\Models\AboutSection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AboutSectionController extends Controller
{
    /**
     * Display a listing of active about sections.
     */
    public function index(): AnonymousResourceCollection
    {
        $aboutSections = AboutSection::with('cards')
            ->where('is_active', true)
            ->latest()
            ->get();

        return AboutSectionResource::collection($aboutSections);
    }

    /**
     * Display the specified about section.
     */
    public function show(AboutSection $aboutSection): AboutSectionResource
    {
        $aboutSection->load('cards');

        return new AboutSectionResource($aboutSection);
    }
}

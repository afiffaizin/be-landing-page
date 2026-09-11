<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeSectionResource;
use App\Models\HomeSection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of active home sections.
     */
    public function index(): AnonymousResourceCollection
    {
        $homeSections = HomeSection::where('is_active', true)
            ->latest()
            ->get();

        return HomeSectionResource::collection($homeSections);
    }

    /**
     * Display the specified home section.
     */
    public function show(HomeSection $homeSection): HomeSectionResource
    {
        return new HomeSectionResource($homeSection);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductSectionResource;
use App\Models\ProductSection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductSectionController extends Controller
{
    /**
     * Display a listing of active product sections.
     */
    public function index(): AnonymousResourceCollection
    {
        $productSections = ProductSection::with('products')
            ->where('is_active', true)
            ->latest()
            ->get();

        return ProductSectionResource::collection($productSections);
    }

    /**
     * Display the specified product section.
     */
    public function show(ProductSection $productSection): ProductSectionResource
    {
        $productSection->load('products');
        
        return new ProductSectionResource($productSection);
    }
}

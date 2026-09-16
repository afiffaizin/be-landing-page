<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\HowToOrderSectionResource;
use App\Models\HowToOrderSection;
use Illuminate\Http\Request;

class HowToOrderController extends Controller
{
    public function index()
    {
        $howToOrderSection = HowToOrderSection::with('steps')
            ->where('is_active', true)
            ->first();

        if (!$howToOrderSection) {
            return response()->json(['data' => null]);
        }

        return new HowToOrderSectionResource($howToOrderSection);
    }
}

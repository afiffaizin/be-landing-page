<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactSectionResource;
use App\Models\ContactSection;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function index(): ContactSectionResource|JsonResponse
    {
        $contactSection = ContactSection::with('items')
            ->where('is_active', true)
            ->latest()
            ->first();

        if (! $contactSection) {
            return response()->json(['data' => null]);
        }

        return new ContactSectionResource($contactSection);
    }
}

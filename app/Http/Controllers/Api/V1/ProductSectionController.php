<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductSectionResource;
use App\Models\ProductSection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ProductSectionController extends Controller
{
    /**
     * Display a listing of active product sections.
     */
    #[OA\Get(
        path: '/products',
        summary: 'Daftar Product Section aktif',
        description: 'Menampilkan semua product section yang berstatus aktif beserta daftar produknya. Digunakan untuk menampilkan katalog produk di landing page.',
        tags: ['Product Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/ProductSection')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $productSections = ProductSection::with('products.detailImages')
            ->where('is_active', true)
            ->latest()
            ->get();

        return ProductSectionResource::collection($productSections);
    }

    /**
     * Display the specified product section.
     */
    #[OA\Get(
        path: '/products/{id}',
        summary: 'Detail Product Section',
        description: 'Menampilkan detail satu product section berdasarkan ID, termasuk daftar produk di dalamnya.',
        tags: ['Product Section'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID Product Section',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Berhasil mengambil data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/ProductSection'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Data tidak ditemukan'),
        ]
    )]
    public function show(ProductSection $productSection): ProductSectionResource
    {
        $productSection->load('products.detailImages');

        return new ProductSectionResource($productSection);
    }
}

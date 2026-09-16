<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSection;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductSectionController extends Controller
{
    /**
     * Display a listing of the product sections.
     */
    public function index(Request $request): View
    {
        $query = ProductSection::query()->with('products')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $productSections = $query->paginate(10)->withQueryString();

        return view('admin.product-section.index', compact('productSections'));
    }

    /**
     * Show the form for creating a new product section.
     */
    public function create(): View
    {
        return view('admin.product-section.create');
    }

    /**
     * Store a newly created product section in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable'],
            'products' => ['nullable', 'array'],
            'products.*.name' => ['nullable', 'string', 'max:255'],
            'products.*.description' => ['nullable', 'string'],
            'products.*.price' => ['nullable', 'string', 'max:255'],
            'products.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        $validated['is_active'] = $isActive;

        // Hanya 1 product section yang aktif: jika section ini aktif, nonaktifkan section lainnya
        if ($isActive) {
            ProductSection::where('is_active', true)->update(['is_active' => false]);
        }

        /** @var ProductSection $productSection */
        $productSection = ProductSection::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'is_active' => $isActive,
        ]);

        // Simpan multiple products
        if ($request->has('products') && is_array($request->input('products'))) {
            $order = 1;
            foreach ($request->input('products') as $index => $productData) {
                $productName = trim($productData['name'] ?? '');
                $productDesc = trim($productData['description'] ?? '');
                $productPrice = trim($productData['price'] ?? '');
                $hasImage = $request->hasFile("products.{$index}.image");

                if ($productName !== '' || $productDesc !== '' || $productPrice !== '' || $hasImage) {
                    $imagePath = null;
                    if ($hasImage) {
                        $imagePath = $request->file("products.{$index}.image")->store('product-images', 'public');
                    }

                    $productSection->products()->create([
                        'name' => $productName ?: 'Product ' . $order,
                        'description' => $productDesc,
                        'price' => $productPrice,
                        'image' => $imagePath,
                        'order' => $order,
                    ]);
                    $order++;
                }
            }
        }

        $message = $isActive
            ? 'Product section berhasil dipublikasikan.'
            : 'Product section berhasil disimpan sebagai draft.';

        return redirect()->route('admin.product-sections.index')
            ->with('success', $message);
    }

    /**
     * Show the form for editing the specified product section.
     */
    public function edit(ProductSection $productSection): View
    {
        $productSection->load('products');

        return view('admin.product-section.edit', compact('productSection'));
    }

    /**
     * Update the specified product section in storage.
     */
    public function update(Request $request, ProductSection $productSection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable'],
            'products' => ['nullable', 'array'],
            'products.*.id' => ['nullable', 'integer'],
            'products.*.name' => ['nullable', 'string', 'max:255'],
            'products.*.description' => ['nullable', 'string'],
            'products.*.price' => ['nullable', 'string', 'max:255'],
            'products.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'products.*.remove_image' => ['nullable', 'boolean'],
        ]);

        $action = $request->input('action');
        if ($action === 'draft') {
            $isActive = false;
        } elseif ($action === 'publish') {
            $isActive = true;
        } else {
            $isActive = $request->boolean('is_active');
        }

        $validated['is_active'] = $isActive;

        // Hanya 1 product section yang aktif: jika section ini aktif, nonaktifkan section lainnya
        if ($isActive) {
            ProductSection::where('id', '!=', $productSection->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $productSection->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'is_active' => $isActive,
        ]);

        // Tangani sync products
        $submittedProducts = $request->input('products', []);
        $existingProducts = $productSection->products()->get()->keyBy('id');
        $keptProductIds = [];

        if (is_array($submittedProducts)) {
            $order = 1;
            foreach ($submittedProducts as $index => $productData) {
                $productId = !empty($productData['id']) ? (int) $productData['id'] : null;
                $productName = trim($productData['name'] ?? '');
                $productDesc = trim($productData['description'] ?? '');
                $productPrice = trim($productData['price'] ?? '');
                $hasImage = $request->hasFile("products.{$index}.image");
                $removeImage = !empty($productData['remove_image']);

                if ($productId && $existingProducts->has($productId)) {
                    /** @var Product $product */
                    $product = $existingProducts->get($productId);
                    $imagePath = $product->image;

                    if ($removeImage && $imagePath) {
                        if (Storage::disk('public')->exists($imagePath)) {
                            Storage::disk('public')->delete($imagePath);
                        }
                        $imagePath = null;
                    }

                    if ($hasImage) {
                        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                            Storage::disk('public')->delete($imagePath);
                        }
                        $imagePath = $request->file("products.{$index}.image")->store('product-images', 'public');
                    }

                    $product->update([
                        'name' => $productName ?: 'Product ' . $order,
                        'description' => $productDesc,
                        'price' => $productPrice,
                        'image' => $imagePath,
                        'order' => $order,
                    ]);

                    $keptProductIds[] = $productId;
                    $order++;
                } elseif ($productName !== '' || $productDesc !== '' || $productPrice !== '' || $hasImage) {
                    $imagePath = null;
                    if ($hasImage) {
                        $imagePath = $request->file("products.{$index}.image")->store('product-images', 'public');
                    }

                    $newProduct = $productSection->products()->create([
                        'name' => $productName ?: 'Product ' . $order,
                        'description' => $productDesc,
                        'price' => $productPrice,
                        'image' => $imagePath,
                        'order' => $order,
                    ]);

                    $keptProductIds[] = $newProduct->id;
                    $order++;
                }
            }
        }

        // Hapus product yang dibuang oleh user di form
        foreach ($existingProducts as $existingId => $existingProduct) {
            if (!in_array($existingId, $keptProductIds)) {
                if ($existingProduct->image && Storage::disk('public')->exists($existingProduct->image)) {
                    Storage::disk('public')->delete($existingProduct->image);
                }
                $existingProduct->delete();
            }
        }

        $message = $isActive
            ? 'Product section berhasil diperbarui.'
            : 'Product section berhasil disimpan sebagai draft.';

        return redirect()->route('admin.product-sections.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified product section from storage.
     */
    public function destroy(ProductSection $productSection): RedirectResponse
    {
        // Hapus semua gambar product
        foreach ($productSection->products as $product) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        }

        $productSection->delete();

        return redirect()->route('admin.product-sections.index')
            ->with('success', 'Product section berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified product section.
     */
    public function toggleStatus(ProductSection $productSection): RedirectResponse
    {
        $newStatus = !$productSection->is_active;

        // Hanya 1 product section yang aktif: jika diaktifkan, nonaktifkan section lainnya
        if ($newStatus) {
            ProductSection::where('id', '!=', $productSection->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $productSection->update([
            'is_active' => $newStatus,
        ]);

        $message = $newStatus 
            ? 'Product section berhasil diaktifkan.' 
            : 'Product section berhasil dinonaktifkan.';

        return back()->with('success', $message);
    }
}

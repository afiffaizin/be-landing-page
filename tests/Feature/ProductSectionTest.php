<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductSection;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductSectionTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->user = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $this->user->assignRole('super_admin');

        Storage::fake('public');
    }

    public function test_admin_can_access_product_sections_index_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.product-sections.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Katalog Produk');
        $response->assertSee('Buat Produk Baru');
    }

    public function test_admin_can_access_product_sections_create_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.product-sections.create'));

        $response->assertStatus(200);
        $response->assertSee('Buat Section Produk');
        $response->assertSee('Detail Produk');
        $response->assertSee('Deskripsi Singkat Produk');
    }

    public function test_admin_can_store_product_section_with_product_detail(): void
    {
        $payload = [
            'title' => 'Katalog Produk Herbal Desa',
            'description' => 'Produk alami olahan masyarakat desa.',
            'whatsapp_number' => '6281234567890',
            'action' => 'publish',
            'products' => [
                [
                    'name' => 'Sabun Mandi Eco-Enzyme',
                    'price' => 'Rp 20.000',
                    'benefit' => 'Melembutkan kulit & ramah lingkungan',
                    'description' => 'Sabun alami untuk mandi harian tanpa busa kimia berbahaya.',
                    'detail' => "Komposisi: 100% bahan fermentasi buah & minyak kelapa murni.\nNetto: 100 gram.\nIzin: P-IRT No. 123456.",
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->post(route('admin.product-sections.store'), $payload);

        $response->assertRedirect(route('admin.product-sections.index'));

        $this->assertDatabaseHas('product_sections', [
            'title' => 'Katalog Produk Herbal Desa',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Sabun Mandi Eco-Enzyme',
            'price' => 'Rp 20.000',
            'benefit' => 'Melembutkan kulit & ramah lingkungan',
            'description' => 'Sabun alami untuk mandi harian tanpa busa kimia berbahaya.',
            'detail' => "Komposisi: 100% bahan fermentasi buah & minyak kelapa murni.\nNetto: 100 gram.\nIzin: P-IRT No. 123456.",
        ]);
    }

    public function test_admin_can_access_edit_page_and_see_product_detail(): void
    {
        $section = ProductSection::create([
            'title' => 'Section Uji Edit',
            'description' => 'Deskripsi Section',
            'is_active' => true,
        ]);

        $section->products()->create([
            'name' => 'Produk A',
            'price' => 'Rp 15.000',
            'benefit' => 'Keunggulan Produk A',
            'description' => 'Deskripsi ringkas A',
            'detail' => 'Spesifikasi detail produk A yang sangat lengkap.',
            'order' => 1,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.product-sections.edit', $section));

        $response->assertStatus(200);
        $response->assertSee('Detail Produk');
        $response->assertSee('Spesifikasi detail produk A yang sangat lengkap.');
    }

    public function test_admin_can_update_product_section_and_modify_product_detail(): void
    {
        $section = ProductSection::create([
            'title' => 'Section Update Awal',
            'description' => 'Deskripsi Awal',
            'is_active' => true,
        ]);

        /** @var Product $product */
        $product = $section->products()->create([
            'name' => 'Produk Lama',
            'price' => 'Rp 10.000',
            'benefit' => 'Benefit Lama',
            'description' => 'Deskripsi Lama',
            'detail' => 'Detail Lama',
            'order' => 1,
        ]);

        $payload = [
            'title' => 'Section Update Terkini',
            'description' => 'Deskripsi Terkini',
            'action' => 'publish',
            'products' => [
                [
                    'id' => $product->id,
                    'name' => 'Produk Diperbarui',
                    'price' => 'Rp 18.000',
                    'benefit' => 'Benefit Baru',
                    'description' => 'Deskripsi Baru',
                    'detail' => 'Detail produk telah diperbarui secara profesional.',
                ],
                [
                    'name' => 'Produk Tambahan Baru',
                    'price' => 'Rp 30.000',
                    'benefit' => 'Benefit Tambahan',
                    'description' => 'Deskripsi Tambahan',
                    'detail' => 'Detail produk tambahan baru.',
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->put(route('admin.product-sections.update', $section), $payload);

        $response->assertRedirect(route('admin.product-sections.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Produk Diperbarui',
            'price' => 'Rp 18.000',
            'detail' => 'Detail produk telah diperbarui secara profesional.',
        ]);

        $this->assertDatabaseHas('products', [
            'product_section_id' => $section->id,
            'name' => 'Produk Tambahan Baru',
            'detail' => 'Detail produk tambahan baru.',
        ]);
    }

    public function test_admin_can_store_product_section_with_up_to_5_detail_images(): void
    {
        $detailImages = [
            UploadedFile::fake()->image('detail1.jpg'),
            UploadedFile::fake()->image('detail2.png'),
            UploadedFile::fake()->image('detail3.webp'),
        ];

        $payload = [
            'title' => 'Katalog Dengan Detail Gambar',
            'description' => 'Deskripsi Katalog',
            'action' => 'publish',
            'products' => [
                [
                    'name' => 'Produk Galeri',
                    'price' => 'Rp 25.000',
                    'description' => 'Produk dengan detail gambar',
                    'detail_images' => $detailImages,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->post(route('admin.product-sections.store'), $payload);

        $response->assertRedirect(route('admin.product-sections.index'));

        $product = Product::where('name', 'Produk Galeri')->first();
        $this->assertNotNull($product);
        $this->assertCount(3, $product->detailImages);

        foreach ($product->detailImages as $detailImage) {
            Storage::disk('public')->assertExists($detailImage->image);
        }
    }

    public function test_cannot_store_product_section_with_more_than_5_detail_images(): void
    {
        $detailImages = [
            UploadedFile::fake()->image('detail1.jpg'),
            UploadedFile::fake()->image('detail2.jpg'),
            UploadedFile::fake()->image('detail3.jpg'),
            UploadedFile::fake()->image('detail4.jpg'),
            UploadedFile::fake()->image('detail5.jpg'),
            UploadedFile::fake()->image('detail6.jpg'),
        ];

        $payload = [
            'title' => 'Katalog Melebihi Batas',
            'description' => 'Deskripsi Katalog',
            'action' => 'publish',
            'products' => [
                [
                    'name' => 'Produk 6 Gambar',
                    'price' => 'Rp 25.000',
                    'description' => 'Deskripsi',
                    'detail_images' => $detailImages,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->post(route('admin.product-sections.store'), $payload);

        $response->assertSessionHasErrors('products.0.detail_images');
    }

    public function test_admin_can_update_product_and_remove_or_add_detail_images(): void
    {
        $section = ProductSection::create([
            'title' => 'Section Detail Gambar Update',
            'description' => 'Deskripsi',
            'is_active' => true,
        ]);

        /** @var Product $product */
        $product = $section->products()->create([
            'name' => 'Produk Update Gambar',
            'price' => 'Rp 10.000',
            'description' => 'Deskripsi',
            'order' => 1,
        ]);

        $img1 = $product->detailImages()->create([
            'image' => 'product-detail-images/test1.jpg',
            'order' => 1,
        ]);
        Storage::disk('public')->put('product-detail-images/test1.jpg', 'fake content 1');

        $img2 = $product->detailImages()->create([
            'image' => 'product-detail-images/test2.jpg',
            'order' => 2,
        ]);
        Storage::disk('public')->put('product-detail-images/test2.jpg', 'fake content 2');

        $newImage = UploadedFile::fake()->image('new_detail.png');

        $payload = [
            'title' => 'Section Detail Gambar Updated',
            'action' => 'publish',
            'products' => [
                [
                    'id' => $product->id,
                    'name' => 'Produk Update Gambar',
                    'price' => 'Rp 10.000',
                    'description' => 'Deskripsi',
                    'remove_detail_images' => [$img1->id],
                    'detail_images' => [$newImage],
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->put(route('admin.product-sections.update', $section), $payload);

        $response->assertRedirect(route('admin.product-sections.index'));

        // img1 should be removed from database and disk
        $this->assertDatabaseMissing('product_detail_images', ['id' => $img1->id]);
        Storage::disk('public')->assertMissing('product-detail-images/test1.jpg');

        // img2 should still exist
        $this->assertDatabaseHas('product_detail_images', ['id' => $img2->id]);

        // New image should be created
        $product->refresh();
        $this->assertCount(2, $product->detailImages);
    }

    public function test_api_products_returns_detail_field_and_detail_images(): void
    {
        $section = ProductSection::create([
            'title' => 'Section API',
            'description' => 'Deskripsi API',
            'is_active' => true,
        ]);

        /** @var Product $product */
        $product = $section->products()->create([
            'name' => 'Produk API Test',
            'price' => 'Rp 50.000',
            'benefit' => 'Benefit API',
            'description' => 'Deskripsi Singkat',
            'detail' => 'Komposisi dan petunjuk penggunaan via API.',
            'order' => 1,
        ]);

        $detailImg = $product->detailImages()->create([
            'image' => 'product-detail-images/api_detail.jpg',
            'order' => 1,
        ]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Produk API Test',
            'detail' => 'Komposisi dan petunjuk penggunaan via API.',
        ]);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'products' => [
                        '*' => [
                            'detail_images' => [
                                '*' => ['id', 'product_id', 'image_url', 'order'],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function test_destroy_product_section_deletes_detail_images_from_storage(): void
    {
        $section = ProductSection::create([
            'title' => 'Section To Delete',
            'is_active' => true,
        ]);

        /** @var Product $product */
        $product = $section->products()->create([
            'name' => 'Produk Delete Storage',
            'image' => 'product-images/main_del.jpg',
            'order' => 1,
        ]);
        Storage::disk('public')->put('product-images/main_del.jpg', 'main content');

        $product->detailImages()->create([
            'image' => 'product-detail-images/detail_del.jpg',
            'order' => 1,
        ]);
        Storage::disk('public')->put('product-detail-images/detail_del.jpg', 'detail content');

        $response = $this->actingAs($this->user)->delete(route('admin.product-sections.destroy', $section));

        $response->assertRedirect(route('admin.product-sections.index'));
        $this->assertDatabaseMissing('product_sections', ['id' => $section->id]);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);

        Storage::disk('public')->assertMissing('product-images/main_del.jpg');
        Storage::disk('public')->assertMissing('product-detail-images/detail_del.jpg');
    }
}

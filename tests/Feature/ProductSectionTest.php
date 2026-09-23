<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductSection;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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

    public function test_api_products_returns_detail_field(): void
    {
        $section = ProductSection::create([
            'title' => 'Section API',
            'description' => 'Deskripsi API',
            'is_active' => true,
        ]);

        $section->products()->create([
            'name' => 'Produk API Test',
            'price' => 'Rp 50.000',
            'benefit' => 'Benefit API',
            'description' => 'Deskripsi Singkat',
            'detail' => 'Komposisi dan petunjuk penggunaan via API.',
            'order' => 1,
        ]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Produk API Test',
            'detail' => 'Komposisi dan petunjuk penggunaan via API.',
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\AboutSection;
use App\Models\HomeSection;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        Storage::fake('public');
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200)
                 ->assertSee('Admin Portal')
                 ->assertSee('CMS Studio v2.4');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_authenticated_user_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/dashboard');

        $response->assertStatus(200)
                 ->assertSee('Dashboard Overview')
                 ->assertSee('Admin Portal');
    }

    public function test_authenticated_user_can_create_home_section(): void
    {
        $file = UploadedFile::fake()->image('hero.jpg');

        $response = $this->actingAs($this->user)->post(route('admin.home-sections.store'), [
            'title' => 'Pengabdian Masyarakat Inovatif',
            'description' => '<p>Deskripsi program beranda inovatif.</p>',
            'image' => $file,
            'button_one_text' => 'Lihat Program',
            'button_one_link' => '#programs',
            'button_two_text' => 'Kontak',
            'button_two_link' => '#contact',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.home-sections.index'));
        $this->assertDatabaseHas('home_sections', [
            'title' => 'Pengabdian Masyarakat Inovatif',
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_can_create_home_section_as_draft(): void
    {
        $response = $this->actingAs($this->user)->post(route('admin.home-sections.store'), [
            'title' => 'Banner Draf Pengabdian',
            'description' => '<p>Deskripsi banner draf yang belum dipublikasikan.</p>',
            'action' => 'draft',
        ]);

        $response->assertRedirect(route('admin.home-sections.index'))
                 ->assertSessionHas('success', 'Banner Beranda berhasil disimpan sebagai draft!');

        $this->assertDatabaseHas('home_sections', [
            'title' => 'Banner Draf Pengabdian',
            'is_active' => false,
        ]);
    }

    public function test_authenticated_user_can_create_active_banner_and_deactivate_others(): void
    {
        $oldBanner = HomeSection::create([
            'title' => 'Banner Lama Aktif',
            'description' => 'Deskripsi banner lama',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->post(route('admin.home-sections.store'), [
            'title' => 'Banner Baru Pengganti',
            'description' => '<p>Deskripsi banner baru</p>',
            'action' => 'publish',
        ]);

        $response->assertRedirect(route('admin.home-sections.index'));

        $this->assertDatabaseHas('home_sections', [
            'title' => 'Banner Baru Pengganti',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('home_sections', [
            'id' => $oldBanner->id,
            'is_active' => false,
        ]);
    }

    public function test_authenticated_user_can_toggle_home_section_status(): void
    {
        $banner = HomeSection::create([
            'title' => 'Banner Toggle Test',
            'description' => 'Deskripsi banner toggle',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->user)->patch(route('admin.home-sections.toggle-status', $banner));
        $response->assertRedirect();

        $this->assertDatabaseHas('home_sections', [
            'id' => $banner->id,
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_can_create_about_section_with_points(): void
    {
        $file = UploadedFile::fake()->image('about.jpg');

        $response = $this->actingAs($this->user)->post(route('admin.about-sections.store'), [
            'title' => 'Tentang Pengabdian Dosen',
            'description' => '<p>Deskripsi kegiatan tentang pengabdian.</p>',
            'image' => $file,
            'points' => [
                [
                    'number' => 1,
                    'title' => 'Pemberdayaan Masyarakat',
                    'description' => 'Pendampingan dan pelatihan masyarakat.',
                ],
                [
                    'number' => 2,
                    'title' => 'Penerapan IPTEK',
                    'description' => 'Penerapan teknologi tepat guna.',
                ],
            ],
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.about-sections.index'));
        $this->assertDatabaseHas('about_sections', [
            'title' => 'Tentang Pengabdian Dosen',
            'is_active' => true,
        ]);
    }

    public function test_frontend_api_returns_active_home_sections(): void
    {
        HomeSection::create([
            'title' => 'Banner FE Test',
            'description' => 'Deskripsi untuk frontend',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/v1/home');
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Banner FE Test']);
    }

    public function test_frontend_api_returns_active_about_sections(): void
    {
        AboutSection::create([
            'title' => 'About FE Test',
            'description' => 'Deskripsi tentang program',
            'points' => [
                ['number' => 1, 'title' => 'Pilar Satu', 'description' => 'Uraian pilar satu'],
            ],
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/v1/about');
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'About FE Test']);
    }
}

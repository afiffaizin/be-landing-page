<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user for Filament
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Seed landing page content
        $this->call([
            HomeSectionSeeder::class,
            AboutSectionSeeder::class,
        ]);
    }
}

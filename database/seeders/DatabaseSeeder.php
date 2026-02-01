<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
        Brand::create([
            'name' => 'nike',
            'icon' => '...',
        ]);
        Brand::create([
            'name' => 'adidas',
            'icon' => '...',
        ]);
        Category::create([
            'name' => 'shoes',
            'icon' => '...',
        ]);
        Category::create([
            'name' => 'Fashion man',
            'icon' => '...',
        ]);
        Produk::create([
            'name' => 'adidas aliodas',
            'thumbnail' => '...',
            'about' => 'ini sepatu aliodas',
            'price' => 3000000,
            'stock' => 99,
            'is_popular' => true,
            'category_id' => 1,
            'brand_id' => 1,

        ]);
    }
}

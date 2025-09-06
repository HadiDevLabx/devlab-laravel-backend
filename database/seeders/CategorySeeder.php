<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest electronic gadgets and devices',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400',
                'is_active' => true
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashion and apparel for all occasions',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=400',
                'is_active' => true
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Wide selection of books and literature',
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400',
                'is_active' => true
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Home improvement and garden supplies',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400',
                'is_active' => true
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Sports equipment and fitness gear',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

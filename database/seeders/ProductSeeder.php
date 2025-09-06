<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        Review::truncate();
        Product::truncate();
        Category::truncate();
        
        // Create categories
        $categories = [
            ['name' => 'Shirts', 'slug' => 'shirts', 'description' => 'Comfortable shirts for everyday wear', 'is_active' => true],
            ['name' => 'Jeans', 'slug' => 'jeans', 'description' => 'Premium denim jeans', 'is_active' => true],
            ['name' => 'Jackets', 'slug' => 'jackets', 'description' => 'Stylish jackets for all seasons', 'is_active' => true],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create products
        $products = [
            [
                'name' => 'Cotton Casual Shirt',
                'slug' => 'cotton-casual-shirt',
                'description' => 'Fashion is a form of self-expression and autonomy at a particular period and place and in a specific context, of clothing, footwear, lifestyle, accessories, makeup, hairstyle, and body posture.',
                'short_description' => 'Made from a sheer Belgian power micromesh. 74% Polyamide (Nylon) 26% Elastane (Spandex)',
                'price' => 45.99,
                'sku' => 'CS001',
                'stock_quantity' => 100,
                'category_id' => 1,
                'is_active' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                'images' => [
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1583743814966-8936f37f4678?w=400&h=400&fit=crop'
                ]
            ],
            [
                'name' => 'Slim Fit Jeans',
                'slug' => 'slim-fit-jeans',
                'description' => 'Fashion is a form of self-expression and autonomy at a particular period and place and in a specific context, of clothing, footwear, lifestyle, accessories, makeup, hairstyle, and body posture.',
                'short_description' => 'Modern slim fit jeans with premium denim. Perfect for casual and formal occasions.',
                'price' => 89.99,
                'sku' => 'SJ001',
                'stock_quantity' => 75,
                'category_id' => 2,
                'is_active' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop',
                'images' => [
                    'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1506629905607-d405872a4b8e?w=400&h=400&fit=crop'
                ]
            ],
            [
                'name' => 'Premium Leather Jacket',
                'slug' => 'premium-leather-jacket',
                'description' => 'Fashion is a form of self-expression and autonomy at a particular period and place and in a specific context, of clothing, footwear, lifestyle, accessories, makeup, hairstyle, and body posture.',
                'short_description' => 'A premium leather jacket made from genuine leather. Perfect for casual and formal occasions.',
                'price' => 299.99,
                'sku' => 'LJ001',
                'stock_quantity' => 50,
                'category_id' => 3,
                'is_active' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&h=400&fit=crop',
                'images' => [
                    'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=400&h=400&fit=crop'
                ]
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create test user for reviews
        $testUser = User::firstOrCreate(
            ['email' => 'reviewer@example.com'],
            ['name' => 'Test Reviewer', 'password' => bcrypt('password')]
        );

        // Create reviews for products
        $reviews = [
            ['product_id' => 1, 'title' => 'Great quality shirt!', 'comment' => 'Love the fabric and fit. Very comfortable for daily wear.', 'rating' => 5],
            ['product_id' => 1, 'title' => 'Good value', 'comment' => 'Nice shirt for the price. Material feels good.', 'rating' => 4],
            ['product_id' => 2, 'title' => 'Perfect fit jeans', 'comment' => 'These jeans fit perfectly and look great. Highly recommend!', 'rating' => 5],
            ['product_id' => 2, 'title' => 'Comfortable', 'comment' => 'Very comfortable jeans, great for everyday wear.', 'rating' => 4],
            ['product_id' => 3, 'title' => 'Amazing leather jacket', 'comment' => 'Premium quality leather, looks and feels expensive. Worth every penny!', 'rating' => 5],
            ['product_id' => 3, 'title' => 'Stylish and durable', 'comment' => 'Beautiful jacket that goes with everything. Great craftsmanship.', 'rating' => 5],
        ];

        foreach ($reviews as $reviewData) {
            Review::create(array_merge($reviewData, ['user_id' => $testUser->id, 'is_verified_purchase' => true]));
        }
    }
}
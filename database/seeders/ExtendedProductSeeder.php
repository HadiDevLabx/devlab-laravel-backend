<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExtendedProductSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        Review::truncate();
        Product::truncate();
        Category::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Create categories
        $categories = [
            ['name' => 'Shirts', 'slug' => 'shirts', 'description' => 'Comfortable shirts for everyday wear', 'is_active' => true],
            ['name' => 'Jeans', 'slug' => 'jeans', 'description' => 'Premium denim jeans', 'is_active' => true],
            ['name' => 'Jackets', 'slug' => 'jackets', 'description' => 'Stylish jackets for all seasons', 'is_active' => true],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create anonymous users for reviews
        $anonymousUsers = [];
        $userNames = ['Alex Johnson', 'Sarah Wilson', 'Mike Davis', 'Emma Brown', 'John Smith', 'Lisa Garcia', 'David Miller', 'Anna Taylor', 'Chris Anderson', 'Maria Rodriguez'];
        
        foreach ($userNames as $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@example.com';
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => bcrypt('password')]
            );
            $anonymousUsers[] = $user;
        }

        // Shirts products
        $shirtsProducts = [
            ['name' => 'Cotton Casual Shirt', 'slug' => 'cotton-casual-shirt', 'price' => 45.99, 'sku' => 'CS001', 'featured_image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop'],
            ['name' => 'Linen Summer Shirt', 'slug' => 'linen-summer-shirt', 'price' => 52.99, 'sku' => 'CS002', 'featured_image' => 'https://images.unsplash.com/photo-1583743814966-8936f37f4678?w=400&h=400&fit=crop'],
            ['name' => 'Oxford Button Down', 'slug' => 'oxford-button-down', 'price' => 68.99, 'sku' => 'CS003', 'featured_image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400&h=400&fit=crop'],
            ['name' => 'Flannel Check Shirt', 'slug' => 'flannel-check-shirt', 'price' => 42.99, 'sku' => 'CS004', 'featured_image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=400&h=400&fit=crop'],
            ['name' => 'Polo Classic Shirt', 'slug' => 'polo-classic-shirt', 'price' => 38.99, 'sku' => 'CS005', 'featured_image' => 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=400&h=400&fit=crop'],
            ['name' => 'Denim Work Shirt', 'slug' => 'denim-work-shirt', 'price' => 55.99, 'sku' => 'CS006', 'featured_image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=400&h=400&fit=crop'],
            ['name' => 'Hawaiian Print Shirt', 'slug' => 'hawaiian-print-shirt', 'price' => 48.99, 'sku' => 'CS007', 'featured_image' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&h=400&fit=crop'],
            ['name' => 'Striped Casual Shirt', 'slug' => 'striped-casual-shirt', 'price' => 44.99, 'sku' => 'CS008', 'featured_image' => 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?w=400&h=400&fit=crop'],
            ['name' => 'White Dress Shirt', 'slug' => 'white-dress-shirt', 'price' => 72.99, 'sku' => 'CS009', 'featured_image' => 'https://images.unsplash.com/photo-1564859228273-274232fdb516?w=400&h=400&fit=crop'],
            ['name' => 'Vintage Band Tee', 'slug' => 'vintage-band-tee', 'price' => 29.99, 'sku' => 'CS010', 'featured_image' => 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=400&h=400&fit=crop']
        ];

        // Jeans products
        $jeansProducts = [
            ['name' => 'Slim Fit Jeans', 'slug' => 'slim-fit-jeans', 'price' => 89.99, 'sku' => 'SJ001', 'featured_image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop'],
            ['name' => 'Straight Leg Jeans', 'slug' => 'straight-leg-jeans', 'price' => 79.99, 'sku' => 'SJ002', 'featured_image' => 'https://images.unsplash.com/photo-1506629905607-d405872a4b8e?w=400&h=400&fit=crop'],
            ['name' => 'Skinny Fit Jeans', 'slug' => 'skinny-fit-jeans', 'price' => 85.99, 'sku' => 'SJ003', 'featured_image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=400&h=400&fit=crop'],
            ['name' => 'Bootcut Jeans', 'slug' => 'bootcut-jeans', 'price' => 92.99, 'sku' => 'SJ004', 'featured_image' => 'https://images.unsplash.com/photo-1582552938357-32b906df40cb?w=400&h=400&fit=crop'],
            ['name' => 'High Waist Jeans', 'slug' => 'high-waist-jeans', 'price' => 95.99, 'sku' => 'SJ005', 'featured_image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=400&h=400&fit=crop'],
            ['name' => 'Distressed Jeans', 'slug' => 'distressed-jeans', 'price' => 98.99, 'sku' => 'SJ006', 'featured_image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop'],
            ['name' => 'Dark Wash Jeans', 'slug' => 'dark-wash-jeans', 'price' => 88.99, 'sku' => 'SJ007', 'featured_image' => 'https://images.unsplash.com/photo-1565084888279-aca607ecce0c?w=400&h=400&fit=crop'],
            ['name' => 'Light Blue Jeans', 'slug' => 'light-blue-jeans', 'price' => 82.99, 'sku' => 'SJ008', 'featured_image' => 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?w=400&h=400&fit=crop'],
            ['name' => 'Black Jeans', 'slug' => 'black-jeans', 'price' => 91.99, 'sku' => 'SJ009', 'featured_image' => 'https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?w=400&h=400&fit=crop'],
            ['name' => 'Raw Denim Jeans', 'slug' => 'raw-denim-jeans', 'price' => 125.99, 'sku' => 'SJ010', 'featured_image' => 'https://images.unsplash.com/photo-1555689502-c4b22d76c56f?w=400&h=400&fit=crop']
        ];

        // Jackets products
        $jacketsProducts = [
            ['name' => 'Premium Leather Jacket', 'slug' => 'premium-leather-jacket', 'price' => 299.99, 'sku' => 'LJ001', 'featured_image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&h=400&fit=crop'],
            ['name' => 'Denim Jacket', 'slug' => 'denim-jacket', 'price' => 89.99, 'sku' => 'LJ002', 'featured_image' => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?w=400&h=400&fit=crop'],
            ['name' => 'Bomber Jacket', 'slug' => 'bomber-jacket', 'price' => 125.99, 'sku' => 'LJ003', 'featured_image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400&h=400&fit=crop'],
            ['name' => 'Windbreaker Jacket', 'slug' => 'windbreaker-jacket', 'price' => 75.99, 'sku' => 'LJ004', 'featured_image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&h=400&fit=crop'],
            ['name' => 'Puffer Jacket', 'slug' => 'puffer-jacket', 'price' => 159.99, 'sku' => 'LJ005', 'featured_image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=400&fit=crop'],
            ['name' => 'Wool Peacoat', 'slug' => 'wool-peacoat', 'price' => 249.99, 'sku' => 'LJ006', 'featured_image' => 'https://images.unsplash.com/photo-1520975954732-35dd22299614?w=400&h=400&fit=crop'],
            ['name' => 'Track Jacket', 'slug' => 'track-jacket', 'price' => 68.99, 'sku' => 'LJ007', 'featured_image' => 'https://images.unsplash.com/photo-1506629905607-d405872a4b8e?w=400&h=400&fit=crop'],
            ['name' => 'Blazer Jacket', 'slug' => 'blazer-jacket', 'price' => 189.99, 'sku' => 'LJ008', 'featured_image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop'],
            ['name' => 'Hooded Jacket', 'slug' => 'hooded-jacket', 'price' => 95.99, 'sku' => 'LJ009', 'featured_image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=400&fit=crop'],
            ['name' => 'Military Jacket', 'slug' => 'military-jacket', 'price' => 135.99, 'sku' => 'LJ010', 'featured_image' => 'https://images.unsplash.com/photo-1520975954732-35dd22299614?w=400&h=400&fit=crop']
        ];

        // Create all products
        $allProducts = [
            ['products' => $shirtsProducts, 'category_id' => 1],
            ['products' => $jeansProducts, 'category_id' => 2],
            ['products' => $jacketsProducts, 'category_id' => 3]
        ];

        $productId = 1;
        foreach ($allProducts as $categoryData) {
            foreach ($categoryData['products'] as $productData) {
                Product::create([
                    'name' => $productData['name'],
                    'slug' => $productData['slug'],
                    'description' => 'Fashion is a form of self-expression and autonomy at a particular period and place and in a specific context, of clothing, footwear, lifestyle, accessories, makeup, hairstyle, and body posture.',
                    'short_description' => 'Premium quality product made with attention to detail and comfort.',
                    'price' => $productData['price'],
                    'sku' => $productData['sku'],
                    'stock_quantity' => rand(25, 150),
                    'category_id' => $categoryData['category_id'],
                    'is_active' => true,
                    'featured_image' => $productData['featured_image'],
                    'images' => [
                        $productData['featured_image'],
                        'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=400&h=400&fit=crop'
                    ]
                ]);

                // Create 3-5 reviews per product
                $reviewCount = rand(3, 5);
                $reviewTitles = [
                    'Excellent quality!', 'Great value for money', 'Love this product', 'Highly recommend',
                    'Perfect fit', 'Amazing quality', 'Worth every penny', 'Fantastic purchase',
                    'Outstanding product', 'Exceeded expectations', 'Great design', 'Comfortable and stylish'
                ];
                
                $reviewComments = [
                    'This product exceeded my expectations. The quality is outstanding and it fits perfectly.',
                    'Great value for the price. I would definitely buy again and recommend to others.',
                    'Love the design and comfort. It\'s become one of my favorite pieces.',
                    'The material feels premium and the craftsmanship is excellent.',
                    'Perfect for everyday wear. Comfortable and looks great with everything.',
                    'Amazing quality and attention to detail. Very satisfied with this purchase.',
                    'Fits true to size and the color is exactly as shown. Highly recommend!',
                    'This has become my go-to piece. The quality is impressive for the price.',
                    'Excellent product with great durability. Worth every penny spent.',
                    'The design is stylish and modern. Gets compliments every time I wear it.'
                ];

                for ($i = 0; $i < $reviewCount; $i++) {
                    $randomUser = $anonymousUsers[array_rand($anonymousUsers)];
                    Review::create([
                        'product_id' => $productId,
                        'user_id' => $randomUser->id,
                        'title' => $reviewTitles[array_rand($reviewTitles)],
                        'comment' => $reviewComments[array_rand($reviewComments)],
                        'rating' => rand(4, 5), // High ratings between 4-5
                        'is_verified_purchase' => rand(0, 1) == 1
                    ]);
                }

                $productId++;
            }
        }
    }
}
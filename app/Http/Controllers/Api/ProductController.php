<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'reviews'])->where('is_active', true);

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category slug
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by category ID
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by colors (if you have color field)
        if ($request->has('colors') && $request->colors) {
            $colors = is_array($request->colors) ? $request->colors : explode(',', $request->colors);
            $query->where(function($q) use ($colors) {
                foreach ($colors as $color) {
                    $q->orWhere('name', 'like', '%' . $color . '%')
                      ->orWhere('description', 'like', '%' . $color . '%');
                }
            });
        }

        // Filter by sizes (if you have size field)
        if ($request->has('sizes') && $request->sizes) {
            $sizes = is_array($request->sizes) ? $request->sizes : explode(',', $request->sizes);
            $query->where(function($q) use ($sizes) {
                foreach ($sizes as $size) {
                    $q->orWhere('name', 'like', '%' . $size . '%')
                      ->orWhere('description', 'like', '%' . $size . '%');
                }
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Handle different sort options
        switch ($sortBy) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate($request->get('per_page', 12));
        
        // Add calculated rating and review count to each product
        $products->getCollection()->transform(function ($product) {
            $product->rating = $product->reviews->avg('rating') ?: 0;
            $product->review_count = $product->reviews->count();
            return $product;
        });

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'integer|min:0',
            'images' => 'array',
            'featured_image' => 'string'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sku' => $request->sku,
            'stock_quantity' => $request->stock_quantity ?? 0,
            'category_id' => $request->category_id,
            'images' => $request->images,
            'featured_image' => $request->featured_image,
            'weight' => $request->weight,
            'dimensions' => $request->dimensions
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product->load('category')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['category', 'reviews'])->findOrFail($id);
        
        // Add calculated rating and review count
        $product->rating = $product->reviews->avg('rating') ?: 0;
        $product->review_count = $product->reviews->count();
        
        return response()->json($product);
    }

    /**
     * Display the specified resource by handle/slug.
     */
    public function showByHandle($handle)
    {
        try {
            $product = Product::with(['category', 'reviews.user'])
                ->where('slug', $handle)
                ->where('is_active', true)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Add calculated rating and review count
            $product->rating = $product->reviews->avg('rating') ?: 0;
            $product->review_count = $product->reviews->count();

            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'sku' => 'string|unique:products,sku,' . $id,
            'category_id' => 'exists:categories,id',
            'stock_quantity' => 'integer|min:0',
            'images' => 'array',
            'featured_image' => 'string'
        ]);

        $updateData = $request->only([
            'name', 'description', 'short_description', 'price', 
            'sale_price', 'sku', 'stock_quantity', 'category_id',
            'images', 'featured_image', 'weight', 'dimensions', 'is_active'
        ]);

        if ($request->has('name')) {
            $updateData['slug'] = Str::slug($request->name);
        }

        $product->update($updateData);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product->load('category')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}

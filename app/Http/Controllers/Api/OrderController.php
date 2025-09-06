<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $orders = $user->orders()
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($orders);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'shipping_address' => 'required|array',
            'shipping_address.first_name' => 'required|string',
            'shipping_address.last_name' => 'required|string',
            'shipping_address.email' => 'required|email',
            'shipping_address.phone' => 'required|string',
            'shipping_address.address_1' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.state' => 'required|string',
            'shipping_address.postcode' => 'required|string',
            'billing_address' => 'required|array',
            'payment_method' => 'required|string',
            'total' => 'required|numeric|min:0'
        ]);

        // Get user's cart items
        /** @var User $user */
        $user = Auth::user();
        $cartItems = $user->cartItems;
        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        // Generate order number
        $orderNumber = 'ORD-' . strtoupper(uniqid());

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax_amount' => 0, // Add tax calculation logic if needed
            'shipping_amount' => 0, // Add shipping calculation if needed
            'total' => $request->total,
            'currency' => 'USD',
            'billing_address' => $request->billing_address,
            'shipping_address' => $request->shipping_address,
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'notes' => $request->notes ?? null
        ]);

        // Create order items from cart
        foreach ($cartItems as $cartItem) {
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'total' => $cartItem->quantity * $cartItem->price,
                'product_snapshot' => [
                    'name' => $cartItem->product->name,
                    'image' => $cartItem->product->image,
                    'sku' => $cartItem->product->sku ?? null
                ]
            ]);
        }

        // Clear the cart after successful order creation
        $cartItems->each->delete();

        return response()->json([
            'success' => true,
            'order' => $order->load('orderItems.product'),
            'message' => 'Order created successfully'
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $order = $user->orders()
            ->with('orderItems')
            ->findOrFail($id);
            
        return response()->json($order);
    }
}

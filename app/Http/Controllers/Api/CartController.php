<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class CartController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display the user's cart.
     */
    public function index()
    {
        $cart = Cart::with(['items.product'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            return response()->json([
                'items' => [],
                'total' => 0,
                'item_count' => 0,
            ]);
        }

        return response()->json([
            'items' => $cart->items,
            'total' => $cart->getTotalAmount(),
            'item_count' => $cart->getTotalItems(),
        ]);
    }

    /**
     * Add item to cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active || !$product->in_stock) {
            return response()->json(['message' => 'Product is not available'], 400);
        }

        if ($request->quantity > $product->stock_quantity) {
            return response()->json(['message' => 'Not enough stock available'], 400);
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $product->stock_quantity) {
                return response()->json(['message' => 'Not enough stock available'], 400);
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->getCurrentPrice(),
            ]);
        }

        return response()->json(['message' => 'Item added to cart successfully'], 201);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::whereHas('cart', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        if ($request->quantity > $cartItem->product->stock_quantity) {
            return response()->json(['message' => 'Not enough stock available'], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Cart item updated successfully']);
    }

    /**
     * Remove item from cart.
     */
    public function destroy($id)
    {
        $cartItem = CartItem::whereHas('cart', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart successfully']);
    }

    /**
     * Clear all cart items.
     */
    public function clear()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json(['message' => 'Cart cleared successfully']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingFee = $cartItems->count() > 0 ? 34 : 0;
        $total = $subtotal + $shippingFee;

        return Inertia::render('Cart/Index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shippingFee' => $shippingFee,
            'total' => $total,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $existingItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->where('size', $validated['size'] ?? null)
            ->where('color', $validated['color'] ?? null)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $validated['quantity']);
            $existingItem->refresh();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'size' => $validated['size'] ?? null,
                'color' => $validated['color'] ?? null,
            ]);
        }

        $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => $cartCount,
        ]);
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        if ($validated['quantity'] <= 0) {
            $cartItem->delete();
            $message = 'Item removed from cart';
        } else {
            $cartItem->update(['quantity' => $validated['quantity']]);
            $message = 'Cart updated';
        }

        $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingFee = $cartItems->count() > 0 ? 34 : 0;
        $total = $subtotal + $shippingFee;

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $cartCount,
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total' => $total,
        ]);
    }

    public function destroy(CartItem $cartItem): JsonResponse
    {
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingFee = $cartItems->count() > 0 ? 34 : 0;
        $total = $subtotal + $shippingFee;

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $cartCount,
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total' => $total,
        ]);
    }

    public function clear(): JsonResponse
    {
        CartItem::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
            'cart_count' => 0,
        ]);
    }

    public function count(): JsonResponse
    {
        $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Checkout page — differentiated by source:
     * - 'direct_buy': isolated single Buy Now item (no cart merge)
     * - 'cart_checkout': selective items from cart only
     */
    public function checkout(Request $request)
    {
        $source = $request->query('source', 'cart_checkout');
        $selectedKeys = $request->query('selected', '');

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $cartItems->count() > 0 ? $item->product->price * $item->quantity : 0);
        $shippingFee = $cartItems->count() > 0 ? 200 : 0;
        $total = $subtotal + $shippingFee;

        return Inertia::render('Checkout/Index', [
            'cartItems' => $cartItems,
            'selectedKeys' => $selectedKeys,
            'checkoutSource' => $source,
            'subtotal' => $subtotal,
            'shippingFee' => $shippingFee,
            'total' => $total,
        ]);
    }

    /**
     * Process checkout — handles both cart_checkout and direct_buy paths.
     *
     * For 'cart_checkout': removes only the processed selected items from cart.
     * For 'direct_buy': clears the buyNow item (stored client-side); nothing
     *                   is removed from the cart so other items remain.
     *
     * Expected payload:
     * {
     *   payment_method: 'gcash' | 'cod',
     *   source: 'cart_checkout' | 'direct_buy',
     *   items: [{ product_id, quantity, size, color }, ...]
     * }
     */
    public function processCheckout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:gcash,cod',
            'source' => 'required|in:cart_checkout,direct_buy',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'nullable|string',
            'items.*.color' => 'nullable|string',
        ]);

        $source = $validated['source'];
        $items = $validated['items'];

        if ($source === 'direct_buy') {
            // Buy Now path: no cart items touched.
            // A separate buy_now record could be persisted server-side here
            // and cleared on the client via clearBuyNowItem().
            // For now we just acknowledge the order.
            $total = collect($items)->sum(fn($item) => Product::find($item['product_id'])->price * $item['quantity']);
            $shippingFee = 200;
            $total += $shippingFee;

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'payment_method' => $validated['payment_method'],
                'total' => $total,
            ]);
        }

        // cart_checkout: delete only the specifically checked cart items
        foreach ($items as $item) {
            $query = CartItem::where('user_id', Auth::id())
                ->where('product_id', $item['product_id'])
                ->where('size', $item['size'] ?? null)
                ->where('color', $item['color'] ?? null);

            $cartItem = $query->first();
            if ($cartItem) {
                $cartItem->delete();
            }
        }

        $remainingCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        $remainingItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $subtotal = $remainingItems->sum(fn($i) => $i->product->price * $i->quantity);
        $shippingFee = $remainingItems->count() > 0 ? 200 : 0;

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
            'payment_method' => $validated['payment_method'],
            'total' => collect($items)->sum(fn($item) => Product::find($item['product_id'])->price * $item['quantity']) + 200,
        ]);
    }
}

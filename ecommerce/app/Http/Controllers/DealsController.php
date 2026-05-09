<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DealsController extends Controller
{
    /**
     * Display sale/deals products using real Product model data.
     */
    public function index(Request $request)
    {
        // Fetch active sale/discounted products from the database
        $products = Product::active()
            ->whereNotNull('original_price')
            ->whereColumn('original_price', '>', 'price')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($p) => [
                'id'            => $p->id,
                'name'          => $p->name,
                'originalPrice' => (float) $p->original_price,
                'price'         => (float) $p->price,
                'category'      => $p->category,
                'status'        => $p->status,
                'statusLabel'   => 'SALE',
                'discount'      => $p->hasDiscount() ? $p->getDiscountPercentAttribute() : 0,
                'rating'        => (string) $p->rating,
                'description'   => $p->description ?? '',
                'image'         => $p->image
                    ? (str_starts_with($p->image, '/') || str_starts_with($p->image, 'http') || str_starts_with($p->image, 'data:')
                        ? $p->image
                        : '/images/' . $p->image)
                    : '',
            ]);

        return Inertia::render('Deals/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Show a single deal product.
     */
    public function show($id)
    {
        $product = Product::where('id', (int) $id)
            ->active()
            ->first();

        if (!$product) {
            abort(404);
        }

        $productDetails = [
            'id'            => $product->id,
            'name'          => $product->name,
            'originalPrice' => (float) $product->original_price,
            'price'         => (float) $product->price,
            'category'      => $product->category,
            'status'        => $product->status,
            'statusLabel'   => 'SALE',
            'discount'      => $product->hasDiscount() ? $product->getDiscountPercentAttribute() : 0,
            'rating'        => (string) $product->rating,
            'description'   => $product->description ?? '',
            'image'         => $product->image
                ? (str_starts_with($product->image, '/') || str_starts_with($product->image, 'http') || str_starts_with($product->image, 'data:')
                    ? $product->image
                    : '/images/' . $product->image)
                : '',
        ];

        return Inertia::render('Deals/Show', [
            'product' => $productDetails,
        ]);
    }
}

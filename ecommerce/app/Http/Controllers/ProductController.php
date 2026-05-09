<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Map a Product model to an array with a resolved local image path.
     * image field stores just the filename (e.g. "hood2.jpg");
     * we prefix it with /images/ to point to /public/images/ on the server.
     */
    private function mapProduct(Product $p): array
    {
        $image = $p->image ?? '';
        // Prefix with /images/ only for bare filenames (not absolute/data URLs)
        if ($image && !str_starts_with($image, '/') && !str_starts_with($image, 'http') && !str_starts_with($image, 'data:')) {
            $image = '/images/' . $image;
        }

        $hasDiscount = $p->hasDiscount();

        return [
            'id'            => $p->id,
            'name'          => $p->name,
            'price'         => (float) $p->price,
            'sale_price'    => $hasDiscount ? (float) $p->price : null,
            'originalPrice' => $hasDiscount ? (float) $p->original_price : null,
            'image'         => $image,
            'category'      => $p->category,
            'description'   => $p->description ?? '',
            'rating'        => $p->rating ?? '4.5',
            'discount'      => $hasDiscount ? $p->getDiscountPercentAttribute() : null,
            'statusLabel'   => $hasDiscount ? 'SALE' : null,
        ];
    }

    /**
     * Get home page data: sale items and collection items.
     */
    public function home()
    {
        // Sale items: featured or discounted products
        $saleItems = Product::active()
            ->where(function ($q) {
                $q->where('is_featured', true)
                  ->orWhereNotNull('original_price');
            })
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get()
            ->map(fn ($p) => $this->mapProduct($p));

        // Collections keyed by category name
        $collectionsRaw = Product::active()
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn ($p) => ucfirst($p->category));

        $collections = [];
        foreach ($collectionsRaw as $category => $items) {
            $collections[$category] = $items->map(fn ($p) => $this->mapProduct($p))->values()->toArray();
        }

        return Inertia::render('Dashboard', [
            'homeProducts'    => $saleItems,
            'homeCollections' => $collections,
        ]);
    }

    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $categoryQuery = strtolower($request->query('category', 'all'));
        $searchQuery = strtolower($request->query('search', ''));

        $productsQuery = Product::active();

        if ($categoryQuery !== 'all' && $categoryQuery !== '') {
            $productsQuery->category($categoryQuery);
        }

        if (!empty($searchQuery)) {
            $productsQuery->where(function ($q) use ($searchQuery) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchQuery}%"])
                  ->orWhereRaw('LOWER(category) LIKE ?', ["%{$searchQuery}%"]);
            });
        }

        $products = $productsQuery->orderBy('created_at', 'desc')->get();

        return Inertia::render('Products/Index', [
            'products' => $products,
            'selectedCategory' => $categoryQuery,
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        // Try to find by integer ID first, then by slug
        $product = null;
        if (is_numeric($id)) {
            $product = Product::find((int) $id);
        }
        if (!$product) {
            $product = Product::where('slug', $id)->active()->first();
        }

        if (!$product) {
            // If coming from an Inertia link, redirect back with a flash message
            if (request()->header('X-Inertia')) {
                return redirect()->back()->with('error', 'Product not found.');
            }
            abort(404, 'Product not found.');
        }

        // Get related products (same category, exclude current)
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->active()
            ->limit(4)
            ->get();

        return Inertia::render('Products/Show', [
            'product' => $this->mapProduct($product),
            'relatedProducts' => $relatedProducts->map(fn ($p) => $this->mapProduct($p))->values()->all(),
        ]);
    }

    /**
     * Get products by category (API endpoint for AJAX).
     */
    public function byCategory(Request $request, string $category)
    {
        $products = Product::category($category)
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products,
            'category' => $category,
        ]);
    }

    /**
     * Get new drop products.
     */
    public function newDrops()
    {
        $newDrops = Product::newDrops()
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Products/NewDrops', [
            'products' => $newDrops,
        ]);
    }

    /**
     * Search products (API endpoint).
     */
    public function search(Request $request)
    {
        $query = strtolower($request->query('q', ''));

        $products = Product::where(function ($q) use ($query) {
            $q->whereRaw('LOWER(name) LIKE ?', ["%{$query}%"])
              ->orWhereRaw('LOWER(category) LIKE ?', ["%{$query}%"])
              ->orWhereRaw('LOWER(description) LIKE ?', ["%{$query}%"]);
        })
        ->active()
        ->limit(10)
        ->get();

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }
}
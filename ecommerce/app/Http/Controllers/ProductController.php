<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    private function products()
    {
        return [
            [
                'id' => 1,
                'name' => 'Xiaomi Monitor 27 Inch',
                'price' => 100.00,
                'category' => 'Monitor',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Sharp 27-inch gaming monitor with high refresh rate.',
                'image' => 'https://via.placeholder.com/800x600?text=Xiaomi+Monitor+27+Inch'
            ],
            [
                'id' => 2,
                'name' => 'Xiaomi 14T',
                'price' => 450.00,
                'category' => 'Smartphone',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Premium smartphone with a powerful camera system.',
                'image' => 'https://via.placeholder.com/800x600?text=Xiaomi+14T'
            ],
            [
                'id' => 3,
                'name' => 'Bomber Jacket',
                'price' => 120.00,
                'category' => 'Jackets',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Stylish jacket with a comfortable fit and premium finish.',
                'image' => 'https://via.placeholder.com/800x600?text=Bomber+Jacket'
            ],
            [
                'id' => 4,
                'name' => 'Classic Cotton Tshirt',
                'price' => 35.00,
                'category' => 'Tshirt',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Soft cotton tshirt available in multiple colors.',
                'image' => 'https://via.placeholder.com/800x600?text=Classic+Cotton+Tshirt'
            ],
            [
                'id' => 5,
                'name' => 'Street Shorts',
                'price' => 45.00,
                'category' => 'Shorts',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Lightweight shorts built for comfort and movement.',
                'image' => 'https://via.placeholder.com/800x600?text=Street+Shorts'
            ],
            [
                'id' => 6,
                'name' => 'Comfort Sando',
                'price' => 28.00,
                'category' => 'Sando',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Breathable sando for warm weather wear.',
                'image' => 'https://via.placeholder.com/800x600?text=Comfort+Sando'
            ],
            [
                'id' => 7,
                'name' => 'Samsung Galaxy A35',
                'price' => 274.00,
                'category' => 'Smartphone',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Stylish phone with a vivid display and long battery life.',
                'image' => 'https://via.placeholder.com/800x600?text=Samsung+Galaxy+A35'
            ],
            [
                'id' => 8,
                'name' => 'Philips Monitor 24 Inch',
                'price' => 140.00,
                'category' => 'Monitor',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Reliable 24-inch display for office and entertainment.',
                'image' => 'https://via.placeholder.com/800x600?text=Philips+Monitor+24+Inch'
            ]
        ];
    }

    public function index(Request $request)
    {
        $categoryQuery = strtolower($request->query('category', 'all'));

        $filteredProducts = collect($this->products())->filter(function ($product) use ($categoryQuery) {
            if ($categoryQuery === 'all' || $categoryQuery === '') {
                return true;
            }

            return strtolower($product['category']) === strtolower($categoryQuery);
        })->values()->all();

        return Inertia::render('Products/Index', [
            'products' => $filteredProducts,
            'selectedCategory' => $categoryQuery,
        ]);
    }

    public function show($product)
    {
        $productDetails = collect($this->products())->firstWhere('id', (int) $product);

        if (! $productDetails) {
            abort(404);
        }

        return Inertia::render('Products/Show', [
            'product' => $productDetails,
        ]);
    }
}

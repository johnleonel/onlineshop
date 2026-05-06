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
                'name' => 'Classic brown polo',
                'price' => 100.00,
                'category' => 'Polo',
                'status' => 'active',
                'statusLabel' => 'outofstock',
                'rating' => '4.6',
                'description' => 'Sharp 27-inch gaming monitor with high refresh rate.',
                'image' => '/images/hood1.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Xiaomi 14T',
                'price' => 450.00,
                'category' => 'Polo',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Premium smartphone with a powerful camera system.',
                'image' => '/images/hood2.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Bomber polo',
                'price' => 120.00,
                'category' => 'Polo',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Stylish jacket with a comfortable fit and premium finish.',
                'image' => '/images/hood3.jpg'
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
                'image' => '/images/hood4.jpg'
            ],
            [
                'id' => 5,
                'name' => 'Redbull Shirt',
                'price' => 45.00,
                'category' => 'Shirts',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Lightweight shorts built for comfort and movement.',
                'image' => '/images/hood5.jpg'
            ],
            [
                'id' => 6,
                'name' => 'Ferrari Shirt',
                'price' => 28.00,
                'category' => 'Shirts',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Breathable sando for warm weather wear.',
                'image' => '/images/hood6.jpg'
            ],
            [
                'id' => 7,
                'name' => 'Ducati Polo Shirt',
                'price' => 274.00,
                'category' => 'Polo',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Stylish phone with a vivid display and long battery life.',
                'image' => '/images/hood7.jpg'
            ],
            [
                'id' => 8,
                'name' => 'B&W Polo Shirt',
                'price' => 750.00,
                'category' => 'Polo',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Reliable 24-inch display for office and entertainment.',
                'image' => '/images/hood8.jpg'
            ],
            [
            'id' => 9,
            'name' => 'Urban Polo',
            'price' => 1500.00,
            'category' => 'Polo',
            'status' => 'active',
            'statusLabel' => 'New Arrival',
            'rating' => '4.8',
            'description' => 'Water-resistant windbreaker perfect for the rainy season.',
            'image' => '/images/more1.jpg'
            ],
            [
                'id' => 10,
                'name' => 'Urban Cargo Pants',
                'price' => 1200.00,
                'category' => 'Pants',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.7',
                'description' => 'Multi-pocket cargo pants for your daily street style.',
                'image' => '/images/more2.jpg'
            ],
            [
                'id' => 11,
                'name' => 'Chillerox Beanie',
                'price' => 350.00,
                'category' => 'Accessories',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.9',
                'description' => 'Knitted beanie with embroidered logo.',
                'image' => '/images/more3.jpg'
            ],
            [
                'id' => 12,
                'name' => 'Denim Trucker Jacket',
                'price' => 1800.00,
                'category' => 'Jackets',
                'status' => 'active',
                'statusLabel' => 'Limited',
                'rating' => '4.6',
                'description' => 'Classic washed denim jacket with a modern fit.',
                'image' => '/images/more4.jpg'
            ],
            [
                'id' => 13,
                'name' => 'Canvas Tote Bag',
                'price' => 450.00,
                'category' => 'Accessories',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.5',
                'description' => 'Heavy-duty canvas bag for your essentials.',
                'image' => '/images/more1.jpg'
            ],
            [
                'id' => 14,
                'name' => 'Slim Fit Joggers',
                'price' => 950.00,
                'category' => 'Pants',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.7',
                'description' => 'Breathable fabric joggers for gym or casual wear.',
                'image' => '/images/more2.jpg'
            ],
            [
                'id' => 15,
                'name' => 'Premium Leather Belt',
                'price' => 600.00,
                'category' => 'Accessories',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.8',
                'description' => 'Genuine leather belt with matte black buckle.',
                'image' => '/images/more3.jpg'
            ],
            [
                'id' => 16,
                'name' => 'Oversized Flannel Shirt',
                'price' => 850.00,
                'category' => 'Jackets',
                'status' => 'active',
                'statusLabel' => 'Active',
                'rating' => '4.6',
                'description' => 'Soft flannel shirt, perfect as an outer layer.',
                'image' => '/images/more4.jpg'
            ],
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

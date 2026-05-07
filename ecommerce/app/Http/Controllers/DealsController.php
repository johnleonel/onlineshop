<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DealsController extends Controller
{
    private function saleProducts()
    {
        return [
            [
                'id' => 101,
                'name' => 'Trucker Jacket - Black',
                'originalPrice' => 750.00,
                'price' => 500.00,
                'category' => 'Jackets',
                'status' => 'sale',
                'statusLabel' => 'SALE',
                'discount' => 30,
                'rating' => '4.7',
                'description' => 'Premium canvas trucker jacket in brown.',
                'image' => '/images/more9.jpg'
            ],
            [
                'id' => 102,
                'name' => 'Stunna Jacket - black',
                'originalPrice' => 750.00,
                'price' => 530.00,
                'category' => 'Jackets',
                'status' => 'sale',
                'statusLabel' => 'SALE',
                'discount' => 33,
                'rating' => '4.7',
                'description' => 'Premium canvas trucker jacket in gray.',
                'image' => '/images/more7.jpg'
            ],
            [
                'id' => 103,
                'name' => 'Canvas Trucker Jacket - White',
                'originalPrice' => 3000.00,
                'price' => 1500.00,
                'category' => 'Jackets',
                'status' => 'sale',
                'statusLabel' => 'SALE',
                'discount' => 50,
                'rating' => '4.7',
                'description' => 'Premium canvas trucker jacket in white.',
                'image' => '/images/hood3.jpg'
            ],
            [
                'id' => 104,
                'name' => 'Heavy Canvas Cargo Pants - Brown',
                'originalPrice' => 2500.00,
                'price' => 1250.00,
                'category' => 'Pants',
                'status' => 'sale',
                'statusLabel' => 'SALE',
                'discount' => 50,
                'rating' => '4.6',
                'description' => 'Durable heavy canvas cargo pants in brown.',
                'image' => '/images/hood16.jpg'
            ],
            [
                'id' => 105,
                'name' => 'Stunna Jortz',
                'originalPrice' => 2500.00,
                'price' => 1250.00,
                'category' => 'Pants',
                'status' => 'sale',
                'statusLabel' => 'SALE',
                'discount' => 50,
                'rating' => '4.6',
                'description' => 'Durable heavy canvas cargo pants in gray.',
                'image' => '/images/shot1.jpg'
            ],
            [
                'id' => 106,
                'name' => 'Urban Polo - Navy',
                'originalPrice' => 1500.00,
                'price' => 750.00,
                'category' => 'Polo',
                'status' => 'sale',
                'statusLabel' => 'SALE',
                'discount' => 50,
                'rating' => '4.8',
                'description' => 'Classic urban polo shirt in navy blue.',
                'image' => '/images/shot2.jpg'
            ],
            [
                'id' => 107,
                'name' => 'Denim Trucker Jacket',
                'originalPrice' => 1800.00,
                'price' => 900.00,
                'category' => 'Jackets',
                'status' => 'sale',
                'statusLabel' => 'SALE',
                'discount' => 50,
                'rating' => '4.6',
                'description' => 'Classic washed denim jacket with modern fit.',
                'image' => '/images/shot3.jpg'
            ],
            [
                'id' => 108,
                'name' => 'Slim Fit Joggers',
                'originalPrice' => 950.00,
                'price' => 475.00,
                'category' => 'Pants',
                'status' => 'sale',
                'statusLabel' => 'SALE',
                'discount' => 50,
                'rating' => '4.7',
                'description' => 'Breathable slim fit joggers for gym or casual wear.',
                'image' => '/images/shot5.jpg'
            ],
        ];
    }

    public function index(Request $request)
    {
        $saleProducts = $this->saleProducts();

        return Inertia::render('Deals/Index', [
            'products' => $saleProducts,
        ]);
    }

    public function show($product)
    {
        $productDetails = collect($this->saleProducts())->firstWhere('id', (int) $product);

        if (! $productDetails) {
            abort(404);
        }

        return Inertia::render('Deals/Show', [
            'product' => $productDetails,
        ]);
    }
}

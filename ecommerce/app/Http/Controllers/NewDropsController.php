<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class NewDropsController extends Controller
{
    public function index()
    {
        $newDrops = Product::newDrops()
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Products/NewDrops', [
            'products' => $newDrops,
        ]);
    }
}

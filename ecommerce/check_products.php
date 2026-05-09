<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$total = App\Models\Product::count();
$featured = App\Models\Product::where('is_featured', true)->count();
$withOriginalPrice = App\Models\Product::whereNotNull('original_price')->count();

echo "Total products: $total\n";
echo "Featured products: $featured\n";
echo "With original_price (sale-eligible): $withOriginalPrice\n";
echo "\n";

if ($total > 0) {
    echo "Sample products with image paths:\n";
    foreach (App\Models\Product::take(3)->get(['name', 'image']) as $p) {
        $mapped = '/images/' . $p->image;
        echo "  {$p->name} → DB: '{$p->image}' → Resolved: '$mapped'\n";
    }
} else {
    echo "WARNING: NO PRODUCTS IN DATABASE. Run: php artisan db:seed\n";
}
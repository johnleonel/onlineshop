<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate home() saleItems query
$saleItems = App\Models\Product::active()
    ->where(function ($q) {
        $q->where('is_featured', true)
          ->orWhereNotNull('original_price');
    })
    ->orderBy('created_at', 'desc')
    ->limit(12)
    ->get(['name','category','image','is_featured','original_price']);

echo "Sale items (" . count($saleItems) . "):\n";
foreach ($saleItems as $p) {
    echo "  - {$p->name} | {$p->category} | {$p->image}\n";
}

// Simulate collections query
$collectionsRaw = App\Models\Product::active()
    ->orderBy('created_at', 'desc')
    ->get()
    ->groupBy(fn($p) => ucfirst($p->category ?? 'Uncategorized'));

echo "\nCollections (" . count($collectionsRaw) . " groups):\n";
foreach ($collectionsRaw as $cat => $items) {
    echo "  {$cat}: " . count($items) . " items\n";
}
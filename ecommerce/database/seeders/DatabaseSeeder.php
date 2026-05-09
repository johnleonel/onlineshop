<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure test user exists
        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // ── Products using local images from /public/images/ ──
        // Naming pattern matches actual files in /public/images/
        //   e.g. hood2.jpg, pot1.jpg, sale1.jpg, more1.jpg, etc.

        $products = [
            // ── HOODIES (collection: "Hoodie") ──────────────────
            [
                'name'          => 'Classic Heavy Hoodie',
                'sku'           => 'HOOD-001',
                'category'      => 'hoodie',
                'price'         => 1299.00,
                'original_price'=> 1599.00,
                'description'   => 'Premium heavyweight hoodie with fleece lining. Features a spacious kangaroo pocket and reinforced stitching.',
                'image'         => 'hood2.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.8,
                'stock'         => 45,
                'is_featured'   => true,
                'is_new_drop'   => false,
            ],
            [
                'name'          => 'Essential Zip Hoodie',
                'sku'           => 'HOOD-002',
                'category'      => 'hoodie',
                'price'         => 1499.00,
                'original_price'=> 1899.00,
                'description'   => 'Full-zip essential hoodie with split kangaroo pocket and adjustable drawstring hood.',
                'image'         => 'hood3.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.7,
                'stock'         => 38,
                'is_featured'   => true,
                'is_new_drop'   => false,
            ],
            [
                'name'          => 'Graphic Print Hoodie',
                'sku'           => 'HOOD-003',
                'category'      => 'hoodie',
                'price'         => 1399.00,
                'description'   => 'Bold graphic print hoodie with oversized fit. Made from 100% organic cotton.',
                'image'         => 'hood4.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.6,
                'stock'         => 52,
                'is_featured'   => false,
                'is_new_drop'   => true,
            ],
            [
                'name'          => 'Oversized Drop-Shoulder Hoodie',
                'sku'           => 'HOOD-004',
                'category'      => 'hoodie',
                'price'         => 1599.00,
                'description'   => 'Oversized fit with dropped shoulders and raw-edge hem. Ultimate streetwear comfort.',
                'image'         => 'hood13.jpg',
                'status'        => 'active',
                'status_label'  => 'Low Stock',
                'rating'        => 4.9,
                'stock'         => 12,
                'is_featured'   => false,
                'is_new_drop'   => true,
            ],
            [
                'name'          => 'Pullover Fleece Hoodie',
                'sku'           => 'HOOD-005',
                'category'      => 'hoodie',
                'price'         => 1199.00,
                'original_price'=> 1499.00,
                'description'   => 'Soft pullover fleece hoodie with ribbed cuffs and hem. Perfect for layering.',
                'image'         => 'hood14.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.5,
                'stock'         => 60,
                'is_featured'   => true,
                'is_new_drop'   => false,
            ],

            // ── POT/TANK TOPS (collection: "Pot") ───────────────
            [
                'name'          => 'Cotton Tank Top',
                'sku'           => 'POT-001',
                'category'      => 'pot',
                'price'         => 499.00,
                'description'   => 'Lightweight cotton tank top with loose fit. Great for workouts or casual wear.',
                'image'         => 'pot1.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.3,
                'stock'         => 80,
                'is_featured'   => false,
                'is_new_drop'   => false,
            ],
            [
                'name'          => 'Slim Fit Muscle Tank',
                'sku'           => 'POT-002',
                'category'      => 'pot',
                'price'         => 599.00,
                'description'   => 'Slim-fit muscle tank with compressed racerback design. Ideal for the gym.',
                'image'         => 'pot2.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.4,
                'stock'         => 65,
                'is_featured'   => false,
                'is_new_drop'   => true,
            ],
            [
                'name'          => 'Layering Tank Top',
                'sku'           => 'POT-003',
                'category'      => 'pot',
                'price'         => 449.00,
                'original_price'=> 699.00,
                'description'   => 'Breathable layering tank in a relaxed boxy cut. Pairs perfectly under hoodies.',
                'image'         => 'pot3.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.2,
                'stock'         => 90,
                'is_featured'   => true,
                'is_new_drop'   => false,
            ],
            [
                'name'          => 'Mesh Vent Tank',
                'sku'           => 'POT-004',
                'category'      => 'pot',
                'price'         => 699.00,
                'description'   => 'Performance mesh tank with side slits for maximum ventilation during training.',
                'image'         => 'pot4.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.6,
                'stock'         => 40,
                'is_featured'   => false,
                'is_new_drop'   => false,
            ],
            [
                'name'          => 'Relaxed Worn-In Tank',
                'sku'           => 'POT-005',
                'category'      => 'pot',
                'price'         => 549.00,
                'original_price'=> 799.00,
                'description'   => 'Worn-in finish relaxed tank with dropped armholes. Vintage feel, modern fit.',
                'image'         => 'pot5.jpg',
                'status'        => 'active',
                'status_label'  => 'Low Stock',
                'rating'        => 4.7,
                'stock'         => 18,
                'is_featured'   => true,
                'is_new_drop'   => false,
            ],

            // ── SHORTS (collection: "Shorts") ───────────────────
            [
                'name'          => 'Comfort Fit Board Shorts',
                'sku'           => 'SHORT-001',
                'category'      => 'shorts',
                'price'         => 899.00,
                'original_price'=> 1199.00,
                'description'   => 'Quick-dry board shorts with elastic waistband and drawstring closure.',
                'image'         => 'shot1.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.5,
                'stock'         => 55,
                'is_featured'   => true,
                'is_new_drop'   => false,
            ],
            [
                'name'          => 'Cargo Utility Shorts',
                'sku'           => 'SHORT-002',
                'category'      => 'shorts',
                'price'         => 1099.00,
                'description'   => 'Multi-pocket cargo shorts in a relaxed fit. Durable ripstop fabric.',
                'image'         => 'shot2.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.4,
                'stock'         => 35,
                'is_featured'   => false,
                'is_new_drop'   => true,
            ],
            [
                'name'          => 'Performance Training Shorts',
                'sku'           => 'SHORT-003',
                'category'      => 'shorts',
                'price'         => 999.00,
                'description'   => '4-way stretch training shorts with built-in liner. Perfect for intense workouts.',
                'image'         => 'shot3.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.8,
                'stock'         => 48,
                'is_featured'   => false,
                'is_new_drop'   => false,
            ],

            // ── T-SHIRTS / POLO (collection: "T-shirt") ─────────
            [
                'name'          => 'Basic Solid Crew Tee',
                'sku'           => 'TSHIRT-001',
                'category'      => 't-shirt',
                'price'         => 599.00,
                'original_price'=> 899.00,
                'description'   => 'Essential cotton crew-neck t-shirt with a relaxed fit. An everyday wardrobe staple.',
                'image'         => 'more1.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.5,
                'stock'         => 120,
                'is_featured'   => true,
                'is_new_drop'   => false,
            ],
            [
                'name'          => 'Polo Classic Fit',
                'sku'           => 'TSHIRT-002',
                'category'      => 'polo',
                'price'         => 799.00,
                'description'   => 'Classic fit polo with ribbed collar and three-button placket. Made from piqué cotton.',
                'image'         => 'more2.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.6,
                'stock'         => 70,
                'is_featured'   => false,
                'is_new_drop'   => true,
            ],
            [
                'name'          => 'Graphic Oversized Tee',
                'sku'           => 'TSHIRT-003',
                'category'      => 't-shirt',
                'price'         => 749.00,
                'original_price'=> 999.00,
                'description'   => 'Large-format graphic print on heavyweight cotton. Oversized drop-shoulder cut.',
                'image'         => 'more3.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.7,
                'stock'         => 88,
                'is_featured'   => true,
                'is_new_drop'   => false,
            ],
            [
                'name'          => 'Pocket Tee Solid',
                'sku'           => 'TSHIRT-004',
                'category'      => 't-shirt',
                'price'         => 549.00,
                'description'   => 'Single-pocket crew tee with reinforced seams. Compact folded sleeve.',
                'image'         => 'more4.jpg',
                'status'        => 'active',
                'status_label'  => 'In Stock',
                'rating'        => 4.3,
                'stock'         => 95,
                'is_featured'   => false,
                'is_new_drop'   => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
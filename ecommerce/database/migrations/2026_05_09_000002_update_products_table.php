<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->after('name')->nullable();
            $table->string('status')->default('active')->after('category');
            $table->string('status_label')->nullable()->after('status');
            $table->string('image')->nullable()->change();
            $table->decimal('original_price', 8, 2)->nullable()->after('price');
            $table->decimal('rating', 3, 1)->nullable()->after('status_label');
            $table->string('sku')->nullable()->unique()->after('id');
            $table->integer('stock')->default(0)->after('rating');
            $table->boolean('is_featured')->default(false)->after('stock');
            $table->boolean('is_new_drop')->default(false)->after('is_featured');
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'status',
                'status_label',
                'original_price',
                'rating',
                'sku',
                'stock',
                'is_featured',
                'is_new_drop',
            ]);
        });
    }
};
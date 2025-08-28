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
            // Champs pour les promotions
            $table->decimal('old_price', 10, 2)->nullable()->after('price');
            $table->integer('discount_percentage')->nullable()->after('old_price');

            // Champs pour les évaluations
            $table->decimal('rating', 3, 2)->default(0)->after('description');
            $table->integer('review_count')->default(0)->after('rating');

            // Stock et disponibilité
            $table->integer('stock_quantity')->default(0)->after('brand');
            $table->boolean('in_stock')->default(true)->after('stock_quantity');
            $table->boolean('is_featured')->default(false)->after('in_stock');
            $table->boolean('is_active')->default(true)->after('is_featured');

            // Catégorie et relations
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null')->after('brand');

            // Métadonnées SEO
            $table->string('meta_title')->nullable()->after('is_active');
            $table->text('meta_description')->nullable()->after('meta_title');

            // Informations supplémentaires
            $table->string('short_description', 500)->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'old_price',
                'discount_percentage',
                'rating',
                'review_count',
                'stock_quantity',
                'in_stock',
                'is_featured',
                'is_active',
                'category_id',
                'meta_title',
                'meta_description',
                'short_description',
            ]);
        });
    }
};

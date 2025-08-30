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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Numéro de commande unique
            $table->string('order_number')->unique();

            // Informations client (si vous n'avez pas encore de table users)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();

            // Adresse de livraison
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_country')->default('Guinea');

            // Adresse de facturation (peut être différente)
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_postal_code')->nullable();
            $table->string('billing_country')->nullable();

            // Montants
            $table->decimal('subtotal', 10, 2); // Sous-total (prix des produits)
            $table->decimal('tax_amount', 8, 2)->default(0); // TVA
            $table->decimal('shipping_cost', 8, 2)->default(0); // Frais de livraison
            $table->decimal('discount_amount', 8, 2)->default(0); // Remise appliquée
            $table->decimal('total_amount', 10, 2); // Montant total

            // Statuts
            $table->enum('status', [
                'pending',      // En attente
                'confirmed',    // Confirmée
                'processing',   // En préparation
                'shipped',      // Expédiée
                'delivered',    // Livrée
                'cancelled',    // Annulée
                'refunded'      // Remboursée
            ])->default('pending');

            $table->enum('payment_status', [
                'pending',      // En attente
                'paid',         // Payée
                'failed',       // Échec
                'refunded',     // Remboursée
                'partial'       // Partiellement payée
            ])->default('pending');

            // Méthode de paiement
            $table->enum('payment_method', [
                'cash_on_delivery', // Paiement à la livraison
                'mobile_money',     // Mobile Money
                'bank_transfer',    // Virement bancaire
                'card',            // Carte bancaire
                'wallet'           // Portefeuille électronique
            ])->nullable();

            // Informations de livraison
            $table->enum('shipping_method', [
                'standard',    // Standard
                'express',     // Express
                'pickup'       // Retrait en magasin
            ])->default('standard');

            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->string('tracking_number')->nullable();

            // Code promo utilisé
            $table->string('coupon_code')->nullable();

            // Notes et commentaires
            $table->text('notes')->nullable(); // Notes du client
            $table->text('admin_notes')->nullable(); // Notes administrateur

            // Données de session pour les invités
            $table->string('session_id')->nullable();

            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['status', 'created_at']);
            $table->index(['payment_status', 'created_at']);
            $table->index('user_id');
            $table->index('customer_email');
            $table->index('order_number');
        });

        // Table pivot pour les produits de la commande
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Informations du produit au moment de la commande
            $table->string('product_name'); // Nom au moment de la commande
            $table->string('product_sku'); // SKU au moment de la commande
            $table->decimal('unit_price', 8, 2); // Prix unitaire au moment de la commande
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2); // Prix total pour cette ligne

            // Informations optionnelles du produit
            $table->string('product_image')->nullable();
            $table->text('product_options')->nullable(); // JSON pour les options (couleur, taille, etc.)

            $table->timestamps();

            // Index
            $table->index(['order_id', 'product_id']);
        });

        // Table pour l'historique des statuts de commande
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->text('comment')->nullable();
            $table->string('changed_by')->nullable(); // Qui a changé le statut
            $table->timestamps();

            $table->index(['order_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};

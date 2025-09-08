<?php
// Dans database/migrations/xxxx_xx_xx_xxxxxx_create_order_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Lier le produit à la commande
            $table->foreignId('products_id')->constrained()->onDelete('cascade'); // Lier le produit à la table 'products'
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2); // Prix du produit au moment de l'achat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
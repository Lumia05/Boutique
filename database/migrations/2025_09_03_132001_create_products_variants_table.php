<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            // Lien vers le produit parent
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // Colonnes spécifiques aux variantes
            $table->string('size');
            $table->decimal('price', 8, 2);
            $table->integer('quantite')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
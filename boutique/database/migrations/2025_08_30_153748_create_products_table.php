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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reference')->nullable();
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->string('image');
            $table->string('color')->nullable();

            // C'est ici que l'on définit la clé étrangère
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->json('features')->nullable();
            $table->text('recommended_use')->nullable();
            $table->json('technical_info')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
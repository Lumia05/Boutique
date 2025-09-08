<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Change le type de colonne de JSON à TEXT
            $table->text('features')->nullable()->change();
            $table->text('technical_info')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Cette méthode est optionnelle, mais sert à annuler les changements
        Schema::table('products', function (Blueprint $table) {
            // Revenir au type JSON
            $table->json('features')->nullable()->change();
            $table->json('technical_info')->nullable()->change();
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Change le type de la colonne 'features' en TEXT
            $table->text('features')->change();
            // Assurez-vous que les autres colonnes sont aussi en TEXT si nécessaire
            $table->text('technical_info')->change();
            $table->text('recommended_use')->change();
        });
    }

    public function down(): void
    {
        // La logique de rollback si vous devez revenir en arrière
        Schema::table('products', function (Blueprint $table) {
            // Pour revenir en arrière, vous pourriez avoir à la redéfinir en JSON
            // $table->json('features')->change();
        });
    }
};

<?php

// Dans database/migrations/xxxx_xx_xx_xxxxxx_add_default_to_features_column.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Définit une valeur par défaut d'une chaîne de caractères vide
            $table->text('recommended_use')->default('')->change();
        });
    }

    public function down(): void
    {
        // La logique pour revenir en arrière
        Schema::table('products', function (Blueprint $table) {
            $table->text('recommended_use')->nullable(false)->change();
        });
    }
};
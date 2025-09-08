<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rendre le champ email optionnel (null)
            $table->string('email')->nullable()->change();
            // Ajout des nouvelles colonnes
            $table->string('phone_number')->nullable()->after('email');
            $table->string('quartier')->nullable()->after('phone_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revenir en arrière en cas de rollback
            $table->string('email')->nullable(false)->change();
            $table->dropColumn(['phone_number', 'quartier']);
        });
    }
};
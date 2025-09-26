<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // --- Champs pour l'Expert 1 ---
            $table->string('expert1_name')->nullable();
            $table->string('expert1_email')->nullable();
            $table->string('expert1_phone')->nullable();
            $table->string('expert1_expertise')->nullable(); // NOUVEAU : Catégorie d'expertise
            
            // --- Champs pour l'Expert 2 ---
            $table->string('expert2_name')->nullable();
            $table->string('expert2_email')->nullable();
            $table->string('expert2_phone')->nullable();
            $table->string('expert2_expertise')->nullable(); // NOUVEAU : Catégorie d'expertise

            // --- Horaires de la Boutique ---
            $table->time('opening_time')->nullable();  // NOUVEAU : Heure d'ouverture
            $table->time('closing_time')->nullable();  // NOUVEAU : Heure de fermeture
            $table->string('closing_days')->nullable(); // NOUVEAU : Jours de fermeture (ex: "Dimanche")

            // --- Autres paramètres (ex: message de bas de page) ---
            $table->string('footer_text')->nullable(); // NOUVEAU : Texte du footer
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
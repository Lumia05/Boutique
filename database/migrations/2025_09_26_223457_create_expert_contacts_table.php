<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expert_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // Nom de l'expert
            $table->string('role')->nullable(); // Rôle (Ex: Support, Ventes)
            $table->string('phone')->nullable(); // Numéro de téléphone
            $table->string('whatsapp')->nullable(); // Lien ou numéro WhatsApp
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0); // Ordre d'affichage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expert_contacts');
    }
};
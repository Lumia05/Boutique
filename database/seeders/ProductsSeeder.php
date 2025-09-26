<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;
use App\Models\Category;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vernis = Category::where('slug', 'Vernis')->firstOrFail();
        $primaireMembrane = Category::where('slug', 'primaire-15kg')->firstOrFail();
        $gants = Category::where('slug', 'gants')->firstOrFail();
        $casque = Category::where('slug', 'casque')->firstOrFail();

        // Produit 1 : Peinture liée à une sous-catégorie
        Products::create([
            'name' => 'Peinture Acrylique Murale',
            'reference' => 'PA-001',
            'description' => 'Peinture acrylique mate pour murs et plafonds.',
            'category_id' => $vernis->id,
        ]);

        // Produit 2 : Membrane liée à une sous-catégorie
        Products::create([
            'name' => 'Membrane Primaire d\'Étanchéité',
            'reference' => 'MP-001',
            'description' => 'Sous-couche bitumineuse pour toiture.',
            'category_id' => $primaireMembrane->id,
        ]);

        // Produit 3 : Gants de protection
        Products::create([
            'name' => 'Gants de Sécurité',
            'reference' => 'GS-001',
            'description' => 'Gants de travail résistants aux coupures et aux abrasions.',
            'category_id' => $gants->id,
        ]);

        // Produit 4 : Casque
        Products::create([
            'name' => 'Casque de Chantier',
            'reference' => 'CC-001',
            'description' => 'Casque de protection pour les travaux de construction.',
            'category_id' => $casque->id,
        ]);
    }
}
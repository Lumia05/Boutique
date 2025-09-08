<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des catégories principales (parent_id est null)
        $chaussures = Category::create([
            'name' => 'Chaussures',
            'parent_id' => null
        ]);

        $peinture = Category::create([
            'name' => 'Peinture',
            'parent_id' => null
        ]);

        $membranes = Category::create([
            'name' => 'Membranes',
            'parent_id' => null
        ]);

        // Création d'une catégorie qui n'a pas de sous-catégorie

        $casque = Category::create([
            'name' => 'Casque',
            'parent_id' => null
        ]);

        $gants = Category::create([
            'name' => 'Gants',
            'parent_id' => null
        ]);

        $botte = Category::create([
            'name' => 'Bottes',
            'parent_id' => null
        ]);

        $masque = Category::create([
            'name' => 'Masque',
            'parent_id' => null
        ]);

    // Création des sous-catégories (avec parent_id pointant vers la catégorie parente)
         // Création de sous-catégories pour "Chaussures"
        Category::create([
            'name' => 'UVEX',
            'parent_id' => $chaussures->id
        ]);
        Category::create([
            'name' => 'NGO',
            'parent_id' => $chaussures->id
        ]);
        
        // Création de sous-catégories pour "Peinture"
        Category::create([
            'name' => 'Peinture Décorative Intérieure',
            'parent_id' => $peinture->id
        ]);
        Category::create([
            'name' => 'Vernis',
            'parent_id' => $peinture->id
        ]);

        Category::create([
            'name' => 'Peinture à Eau Intérieure',
            'parent_id' => $peinture->id
        ]);

        Category::create([
            'name' => 'Peinture à Eau Extérieure',
            'parent_id' => $peinture->id
        ]);

        Category::create([
            'name' => 'Peinture à Eau Intérieure/Extérieure',
            'parent_id' => $peinture->id
        ]);

        Category::create([
            'name' => 'Enduit Intérieure',
            'parent_id' => $peinture->id
        ]);

        Category::create([
            'name' => 'Enduit Intérieure/Extérieure',
            'parent_id' => $peinture->id
        ]);

        Category::create([
            'name' => 'Peinture à huile',
            'parent_id' => $peinture->id
        ]);

        Category::create([
            'name' => 'Anti-rouille',
            'parent_id' => $peinture->id
        ]);

        Category::create([
            'name' => 'Colorants',
            'parent_id' => $peinture->id
        ]);

        // Création de sous-catégories pour "Membranes"
             Category::create([
            'name' => 'Primaire 15kg',
            'parent_id' => $membranes->id
        ]);

        Category::create([
            'name' => 'Sous-couche non-sablées',
            'parent_id' => $membranes->id
        ]);

        Category::create([
            'name' => 'Sous couche sablée',
            'parent_id' => $membranes->id
        ]);
           Category::create([
            'name' => 'Finition Granulée',
            'parent_id' => $membranes->id
        ]);


    }
}
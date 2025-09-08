<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $selectedCategoryId = $request->input('category_id');
        $searchQuery = $request->input('search');

        $query = Products::query(); // Démarre une nouvelle requête

        $contentTitle = 'Tous nos produits';

        // Logique de filtrage par catégorie
        if ($selectedCategoryId) {
            $selectedCategory = Category::find($selectedCategoryId);
            
            if ($selectedCategory) {
                // Si la catégorie a des sous-catégories, on filtre par toutes ses sous-catégories
                if ($selectedCategory->children->count() > 0) {
                    $subCategoryIds = $selectedCategory->children->pluck('id');
                    $query->whereIn('category_id', $subCategoryIds);
                    $contentTitle = $selectedCategory->name;
                } 
                // Sinon, on filtre par la catégorie elle-même
                else {
                    $query->where('category_id', $selectedCategoryId);
                    $parentCategory = $selectedCategory->parent;
                    if ($parentCategory) {
                        $contentTitle = $parentCategory->name . ' / ' . $selectedCategory->name;
                    } else {
                        $contentTitle = $selectedCategory->name;
                    }
                }
            }
        }

        // Logique de recherche par mot-clé
        if ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
        }

        $products = $query->get(); // Exécute la requête finale

        return view('products.index', compact('categories', 'products', 'contentTitle', 'selectedCategoryId'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        // ... (vos règles de validation)
        'features' => 'nullable|string',
        'recommended_use' => 'nullable|string',
        'technical_info' => 'nullable|string',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $validatedData['image'] = 'storage/' . $imagePath;
    }

    // On enregistre les données directement comme des chaînes de caractères
    $validatedData['features'] = $request->features;
    $validatedData['technical_info'] = $request->technical_info;
    $validatedData['recommended_use'] = $request->recommended_use; // Ajouté pour être cohérent
    
    Products::create($validatedData);

    return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès.');
}

/**
 * Met à jour un produit existant dans la base de données.
 */
public function update(Request $request, Products $product)
{
    $validatedData = $request->validate([
        // ... (vos règles de validation)
        'features' => 'nullable|string',
        'recommended_use' => 'nullable|string',
        'technical_info' => 'nullable|string',
    ]);

    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image si elle existe
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $imagePath = $request->file('image')->store('images', 'public');
        $validatedData['image'] = 'storage/' . $imagePath;
    }
    
    // On enregistre les données directement comme des chaînes de caractères
    $validatedData['features'] = $request->features;
    $validatedData['technical_info'] = $request->technical_info;
    $validatedData['recommended_use'] = $request->recommended_use; // Ajouté pour être cohérent
    
    $product->update($validatedData);

    return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès.');
}


   private $colorMap = [
    'blanc' => '#FFFFFF',
    'blanc cassé' => '#F8F8FF',
    'crème' => '#FFFDD0',
    'ivoire' => '#FFFFF0',
    'beige' => '#F5F5DC',
    'rouge bordeau' => '#800000',
    'noir' => '#000000',
    'gris' => '#808080',
    'gris foncé' => '#A9A9A9',
    'gris clair' => '#D3D3D3',
    'argent' => '#C0C0C0',
    'charbon' => '#36454F',
    'brun' => '#A52A2A',
    'marron' => '#800000',
    'chocolat' => '#D2691E',
    'châtaigne' => '#CD5C5C',
    'sienne' => '#A0522D',
    'ocre' => '#CC7722',
    'taupe' => '#483C32',
    'bleu' => '#0000FF',
    'bleu ciel' => '#87CEEB',
    'bleu marine' => '#000080',
    'bleu roi' => '#4169E1',
    'cyan' => '#00FFFF',
    'turquoise' => '#40E0D0',
    'céruléen' => '#007BA7',
    'azur' => '#007FFF',
    'indigo' => '#4B0082',
    'violet' => '#800080',
    'pourpre' => '#800080',
    'lavande' => '#E6E6FA',
    'lilas' => '#B660CD',
    'magenta' => '#FF00FF',
    'fuchsia' => '#FF00FF',
    'rose' => '#FFC0CB',
    'rose vif' => '#FF007F',
    'saumon' => '#FA8072',
    'corail' => '#FF7F50',
    'rouge' => '#FF0000',
    'vermillon' => '#E34234',
    'écarlate' => '#FF2400',
    'bordeaux' => '#800020',
    'grenat' => '#800000',
    'cerise' => '#DE3163',
    'orange' => '#FFA500',
    'tangerine' => '#F28500',
    'citrouille' => '#FF7518',
    'jaune' => '#FFFF00',
    'jaune d\'or' => '#FFD700',
    'citron' => '#FFF73E',
    'crème de citron' => '#F7F4D3',
    'moutarde' => '#FFDB58',
    'vert' => '#008000',
    'vert lime' => '#32CD32',
    'vert olive' => '#808000',
    'vert bouteille' => '#006A4E',
    'vert menthe' => '#98FB98',
    'émeraude' => '#50C878',
    'vert sapin' => '#013220',
    'vert foncé' => '#006400',
    'kaki' => '#C3B091',
    'turquoise' => '#40E0D0',
    'azur' => '#007FFF',
    'cyan' => '#00FFFF',
    'rose fardé' => '#FDEEF4',
    'rose dragée' => '#F9B7FF',
    'rose' => '#E75480',
    'magenta' => '#FF00FF',
    'indigo' => '#4B0082',
    'pourpre' => '#800080',
    'violet' => '#8A2BE2',
    'aubergine' => '#3B0910',
    'bleu ciel' => '#87CEEB',
    'bleu d\'acier' => '#4682B4',
    'bleu pâle' => '#ADD8E6',
    'bleu marine' => '#000080',
    'bleu outremer' => '#0343DF',
    'bleu électrique' => '#7DF9FF',
    'vert d\'eau' => '#9FE2BF',
    'vert de mer' => '#2E8B57',
    'vert jade' => '#00A86B',
    'vert émeraude' => '#50C878',
    'vert olive' => '#808000',
    'vert citron' => '#32CD32',
    'jaune maïs' => '#FBEC5D',
    'or' => '#FFD700',
    'jaune citron' => '#E3F927',
    'orange brûlé' => '#CC5500',
    'orange' => '#ED9121',
    'citrouille' => '#FF7518',
    'rouge écarlate' => '#FF2400',
    'rouge brique' => '#B22222',
    'rouge tomate' => '#FF6347',
    'rouge rubis' => '#E0115F',
    'brun sépia' => '#704214',
    'brun cannelle' => '#D2691E',
    'brun roux' => '#A52A2A',
    'brun cuir' => '#8B4513',
    'gris ardoise' => '#708090',
    'gris anthracite' => '#36454F',
    'gris béton' => '#A9A9A9',
    'gris fer' => '#C4C4C4',
    'ivoire' => '#FFFFF0',
    'blé' => '#F5DEB3',
    'champagne' => '#F7E7CE',
    'platine' => '#E5E4E2',
    'sable' => '#C2B280',
    'ocre' => '#CC7722',
];

    public function show(Products $product)
    {
        // 1. Récupérer la chaîne de couleurs du produit actuel
        $productColorsString = $product->color;

        // 2. Diviser la chaîne en un tableau de noms de couleurs
        $productColorsArray = explode(',', $productColorsString);

        // 3. Convertir les noms de couleurs en codes hexadécimaux
        $hexProductColors = collect($productColorsArray)->map(function ($colorName) {
            return $this->colorMap[strtolower(trim($colorName))] ?? '#808080'; // trim() pour enlever les espaces
        });

        // Les informations techniques et les caractéristiques sont déjà gérées
        return view('products.show', compact('product', 'hexProductColors'));
    }
}
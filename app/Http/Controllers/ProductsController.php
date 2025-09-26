<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductsController extends Controller
{
    /**
     * Affiche une liste de produits, avec des options de filtre par catégorie et de recherche.
     */
    public function index(Request $request)
    {
        // Récupérer toutes les catégories principales avec leurs enfants et le nombre de produits pour chaque
        $categories = Category::whereNull('parent_id')->get();

        $categories->each(function ($category) {
            $descendantIds = $category->children()->pluck('id');
            $allCategoryIds = $descendantIds->push($category->id);
            $category->products_count = Products::whereIn('category_id', $allCategoryIds)->count();
            
            $category->children->each(function ($childCategory) {
                $childDescendantIds = $childCategory->children()->pluck('id');
                $allChildCategoryIds = $childDescendantIds->push($childCategory->id);
                $childCategory->products_count = Products::whereIn('category_id', $allChildCategoryIds)->count();
            });
        });
            
        $selectedCategoryId = $request->input('category_id');

        $query = Products::query();

        if ($selectedCategoryId) {
            $category = Category::find($selectedCategoryId);
            
            if ($category) {
                $descendantIds = $category->children()->pluck('id')->toArray();
                $categoryIds = array_merge([$selectedCategoryId], $descendantIds);
                
                $query->whereIn('category_id', $categoryIds);

                $contentTitle = $category->name;
            } else {
                $contentTitle = "Tous les produits";
            }
        } else {
            $contentTitle = "Tous les produits";
        }

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });

            $contentTitle = "Résultats de la recherche pour \"{$search}\"";
        }
        
        // Charger les variantes des produits
        $products = $query->with('variants')->paginate(9)->withQueryString();

        return view('products.index', compact('products', 'categories', 'selectedCategoryId', 'contentTitle'));
    }

    public function show(Products $product)
    {
        $product->load('variants');
        
        return view('products.show', compact('product'));
    }
}
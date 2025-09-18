<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
                            ->with('children')
                            ->get();

        $products = Products::inRandomOrder()->limit(6)->get();

        return view('welcome', compact('categories', 'products'));
    }

    public function realisations()
    {
        $directory = public_path('storage/images');
        $images = [];

        if (is_dir($directory)) {
            $pattern = $directory . DIRECTORY_SEPARATOR . '*.{jpg,jpeg,png,gif,webp,JPG,JPEG,PNG,GIF,WEBP}';
            $files = glob($pattern, GLOB_BRACE) ?: [];

            // Trier par date de modification décroissante (les plus récents d'abord)
            usort($files, function ($a, $b) {
                return filemtime($b) <=> filemtime($a);
            });

            // Ne garder que les deux premiers
            $files = array_slice($files, 0, 2);

            // Convertir en URLs publiques
            foreach ($files as $path) {
                $basename = basename($path);
                $images[] = asset('storage/images/' . $basename);
            }
        }

        return view('realisations', compact('images'));
    }
}
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
}
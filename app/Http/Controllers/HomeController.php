<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the products on the homepage.
     */
    public function index()
    {
        $products = Products::with('variants')->get();
        return view('welcome', compact('products'));
    }
}
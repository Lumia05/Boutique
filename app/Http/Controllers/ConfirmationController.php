<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConfirmationController extends Controller
{
    public function index()
    {
        // Vider le panier après la commande
        Session::forget('cart');

        // Afficher la page de confirmation
        return view('confirmation.index');
    }
}
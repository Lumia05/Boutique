<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Récupère les utilisateurs qui ont au moins une commande
        // et ne sont pas administrateurs (s'ils ont un champ `is_admin`)
        $clients = User::has('orders')
                       ->where('is_admin', false)
                       ->withCount('orders')
                       ->get();
        
        return view('admin.users.index', compact('clients'));
    }
}
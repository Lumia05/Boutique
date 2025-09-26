<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Supprimez tout utilisateur avec le même email pour éviter les doublons
        DB::table('users')->where('email', 'admin@globalretail.com')->delete();
        
        DB::table('users')->insert([
            'name' => 'Super Admin GRB',
            'email' => 'admin@globalretail.com', // ⬅️ L'EMAIL DE CONNEXION
            'password' => Hash::make('adminpass'), // ⬅️ LE MOT DE PASSE (À CHANGER !)
            'is_admin' => true, // ⬅️ Le rôle est défini ici
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
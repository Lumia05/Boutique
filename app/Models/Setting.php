<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'expert1_name', 'expert1_email', 'expert1_phone', 'expert1_expertise', // Nouveau
        'expert2_name', 'expert2_email', 'expert2_phone', 'expert2_expertise', // Nouveau
        'opening_time', 'closing_time', 'closing_days', 'footer_text', // Nouveaux champs
    ];
}
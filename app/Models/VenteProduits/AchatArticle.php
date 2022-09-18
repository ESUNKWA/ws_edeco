<?php

namespace App\Models\VenteProduits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchatArticle extends Model
{
    use HasFactory;
    protected $table = 't_achat_articles';
    protected $fillable = [
        'r_fournisseur',
        'r_produit',
        'r_quantite',
        'r_prix_achat',
        'r_creer_par',
        'r_modifier_par'
    ];
}

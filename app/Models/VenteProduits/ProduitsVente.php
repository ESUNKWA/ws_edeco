<?php

namespace App\Models\VenteProduits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitsVente extends Model
{
    use HasFactory;
    protected $table = 't_produitventes';
    protected $fillable = [
        'r_nom_produit',
        'r_stock',
        'r_prix_vente',
        'r_description',
        'r_creer_par',
        'r_modifier_par',
        'path_name'
    ];
}

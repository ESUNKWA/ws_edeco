<?php

namespace App\Models\VenteProduits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailVentes extends Model
{
    use HasFactory;
    protected $table = 't_details_ventes';
    protected $fillable = [
        'r_quantite',
        'r_prix_vente',
        'r_creer_par',
        'r_modifier_par',
        'r_produit',
        'r_sous_total',
        'r_vente'
    ];
}

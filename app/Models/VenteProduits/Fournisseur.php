<?php

namespace App\Models\VenteProduits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $table = 't_fournisseurs';
    protected $fillable = [
        'r_nom_fournisseur',
        'r_contact',
        'r_produit_fourni',
        'r_lieu_de_vente',
        'r_description',
        'r_status',
        'r_ets',
        'r_creer_par',
        'r_modifier_par',
    ];
}

<?php

namespace App\Models\metier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achatproduit extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_achats_produits';
    protected $fillable = ['r_produit','r_quantite','r_prix_achat','r_description','r_utilisateur'];
}

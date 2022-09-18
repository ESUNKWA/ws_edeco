<?php

namespace App\Models\metier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_produits';
    protected $fillable = ['r_categorie','r_libelle','r_description','r_stock','r_image','r_utilisateur',];
}

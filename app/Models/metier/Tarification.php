<?php

namespace App\Models\metier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarification extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_tarifications';
    protected $fillable = ['r_produit','r_quantite','r_prix_location','r_date_debut','r_date_fin','r_description','r_duree','r_utilisateur','r_es_utiliser'];
}

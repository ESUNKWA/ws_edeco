<?php

namespace App\Models\location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailslocacation extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_details_locations';
    protected $fillable = ['r_i','r_quantite','r_status','r_description','r_produit',
                            'r_location','r_sous_total','r_utilisateur','r_produit_manquant',
                            'r_prix_location'];
}

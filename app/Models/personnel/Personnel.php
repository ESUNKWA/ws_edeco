<?php

namespace App\Models\personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_personnels';
    protected $fillable = [
        'r_i',
        'r_civilite',
        'r_nom',
        'r_prenoms',
        'r_contact',
        'r_email',
        'r_date_entree',
        'r_date_depart',
        'r_quatier',
        'r_fonction',
        'r_description',
        'r_utilisateur',
        'r_editeur'
    ];
}

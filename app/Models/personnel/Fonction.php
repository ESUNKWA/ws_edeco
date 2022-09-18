<?php

namespace App\Models\personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_fonctions';
    protected $fillable = ['r_i','r_libelle','r_description','r_utilisateur'];
}

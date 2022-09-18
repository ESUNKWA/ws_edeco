<?php

namespace App\Models\metier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistik extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_logistiques';
    protected $fillable = ['r_vehicule','r_matricule','r_description','r_status','r_utilisateur'];
}

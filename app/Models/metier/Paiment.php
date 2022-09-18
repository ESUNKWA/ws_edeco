<?php

namespace App\Models\metier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiment extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_paiement_echellonner';
    protected $fillable = ['r_utilisateur ','r_location','r_mnt','r_description'];
}

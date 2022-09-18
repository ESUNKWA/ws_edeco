<?php

namespace App\Models\metier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communes extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_communes';
    protected $fillable = ['r_libelle','r_description','r_situation_geo','r_status','r_utilisateur'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_profils extends Model
{
    use HasFactory;

    protected $primaryKey = 'r_i';
    protected $table = 't_profils';
    protected $fillable = ['r_code_profil', 'r_libelle', 'r_description','r_status']; 
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_categories';
    protected $fillable = ['r_libelle','r_description','r_utilisateur','r_status'];
}

<?php

namespace App\Models\metier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalite extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_penalite';
    protected $fillable = ['r_location','r_mnt','r_motif','r_utilisateur'];
}

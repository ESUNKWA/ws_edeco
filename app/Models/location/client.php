<?php

namespace App\Models\location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_clients';
    protected $fillable = ['r_nom','r_prenoms','r_telephone','r_email','r_description','r_utilisateur'];
}

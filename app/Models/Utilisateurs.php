<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateurs extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'r_i';
    protected $table = 't_utilisateurs';
    protected $fillable = ['r_personnel','r_profil','r_login','password','r_utilisateur','r_status','r_actif'];

}

<?php

namespace App\Models\VenteProduits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenteProduits extends Model
{
    use HasFactory;
    protected $table = 't_ventes';
    protected $fillable = [
        'r_reference',
        'r_mnt_total',
        'r_creer_par',
        'r_modifier_par'
    ];
}

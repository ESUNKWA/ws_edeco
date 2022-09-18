<?php

namespace App\Models\location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_locations';
    protected $fillable = ['r_solder','r_client','r_num','r_mnt_total','r_status','r_frais_transport','r_destination','r_remise',
                            'r_logistik','r_mnt_total_remise','r_date_envoie','r_date_retour','r_duree','r_utilisateur','r_paiement_echell'];
}

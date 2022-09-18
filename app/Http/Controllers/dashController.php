<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        try {
            $dash = DB::select("SELECT COALESCE(CONVERT(SUM(loc.r_mnt_total_remise),INTEGER),0) as mnt_total_mois, 
            COALESCE(CONVERT(SUM(loc.r_frais_transport),INTEGER),0) as frais_mois,
            (SELECT COUNT(loc.r_i) from t_locations loc WHERE MONTH(loc.created_at) = MONTH(NOW())) as total_location_mois,
            (SELECT COALESCE(CONVERT(SUM(ach.r_prix_achat),INTEGER),0) from t_achats_produits ach WHERE MONTH(ach.created_at) = MONTH(NOW())) as mnt_total_achat_mois,
            (SELECT COALESCE(CONVERT(SUM(loc.r_mnt_total_remise),INTEGER),0) from t_locations loc 
            WHERE loc.r_status NOT IN(0,3) AND loc.r_solder = 1 AND loc.r_paiement_echell = 'null' AND (DATE(loc.created_at) = DATE(NOW()) /*|| DATE(loc.updated_at) = DATE(NOW())*/)) as mnt_total_location_jours,
            (SELECT COALESCE(CONVERT(SUM(loc.r_frais_transport),INTEGER),0) from t_locations loc WHERE loc.r_status = 1 AND DATE(loc.created_at) = DATE(NOW())) as fraisjr,
            (SELECT COALESCE(CONVERT(SUM(pen.r_mnt),INTEGER),0) from t_penalite pen WHERE DATE(pen.created_at) = DATE(NOW())) as mnt_penalite,
            (SELECT COUNT(loc.r_i) from t_locations loc WHERE loc.r_status = 1 AND MONTH(loc.created_at) = MONTH(NOW())) as total_location_mois_encours,
            (SELECT COUNT(loc.r_i) FROM t_locations loc WHERE loc.r_date_retour < DATE(NOW()) AND loc.r_status = 1) as total_location_expire,
            (SELECT COUNT(loc.r_i) from t_locations loc WHERE loc.r_status = 3 AND MONTH(loc.created_at) = MONTH(NOW())) as total_location_mois_rej,
            (SELECT COUNT(loc.r_i) from t_locations loc WHERE loc.r_status = 0 AND MONTH(loc.created_at) = MONTH(NOW())) as total_location_mois_att,
            (SELECT COUNT(loc.r_i) from t_locations loc WHERE loc.r_status = 2 AND MONTH(loc.created_at) = MONTH(NOW())) as total_location_mois_term,
            /*(SELECT JSON_ARRAYAGG(JSON_OBJECT('produit', r_libelle, 'stock', r_stock)) from t_produits) as produits,*/
            (SELECT COUNT(r_i) FROM t_locations WHERE /*t_locations.r_status = 0 AND*/ DATE(t_locations.r_date_envoie) = DATE(DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY))) as nbreLivraisonDemain,
            (SELECT COUNT(r_i) FROM t_locations WHERE /*t_locations.r_status = 0 AND*/ DATE(t_locations.r_date_envoie) = DATE(DATE_ADD(CURRENT_DATE, INTERVAL 0 DAY))) as nbreLivraisonJour,
            (SELECT COUNT(r_i) FROM t_locations WHERE /*t_locations.r_status = 0 AND*/ DATE(t_locations.r_date_retour) = DATE(DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY))) as nbreRetourDemain,
            (SELECT COUNT(r_i) FROM t_locations WHERE /*t_locations.r_status = 0 AND*/ DATE(t_locations.r_date_retour) = DATE(DATE_ADD(CURRENT_DATE, INTERVAL 0 DAY))) as nbreRetourJour
            FROM t_locations loc WHERE loc.r_status NOT IN(0,3) AND loc.r_solder = 1 AND MONTH(loc.created_at) = MONTH(NOW()) ");

            //$LocationStatus = DB::select("SELECT COUNT(r_i), SUM(r_mnt_total_remise) FROM `t_locations` GROUP BY r_status");
            $LocationStatus = DB::select("SELECT COUNT(loc.r_i) as nbre, SUM(r_mnt_total_remise) as total from t_locations loc WHERE MONTH(loc.created_at) = MONTH(NOW()) GROUP BY r_status");
            
            //Statistique des locations mensuelles par produits
            $produitStat = DB::select("SELECT prd.r_libelle as produit, CONVERT(SUM(det.r_sous_total),INTEGER) as total FROM t_produits prd
            INNER JOIN t_details_locations det ON prd.r_i = det.r_produit
            INNER JOIN t_locations loc ON loc.r_i = det.r_location
            WHERE loc.r_status NOT IN(0,3)
            AND MONTH(loc.created_at) = MONTH(NOW())
            GROUP BY prd.r_libelle ORDER BY total DESC");

            $a = DB::select('SELECT MONTH(loc.created_at) as mois, CONVERT(SUM(loc.r_mnt_total_remise),INTEGER) as total FROM t_locations loc
                            WHERE loc.r_status NOT IN (0,3) GROUP BY MONTH(loc.created_at) ORDER BY MONTH(loc.created_at) ASC');

            $mnt_total = DB::select("SELECT loc.r_paiement_echell from t_locations loc where loc.r_paiement_echell <> 'null' ");

            return array_merge([$dash, $LocationStatus, $produitStat,$mnt_total,$a]);
            
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(cr $cr)
    {
        //
    }
}

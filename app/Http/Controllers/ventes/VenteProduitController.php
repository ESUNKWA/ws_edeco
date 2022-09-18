<?php

namespace App\Http\Controllers\ventes;

use App\Models\c;
use Illuminate\Http\Request;
use App\Http\Traits\cryptTrait;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\location\client;
use App\Models\VenteProduits\DetailVentes;
use App\Models\VenteProduits\ProduitsVente;
use Illuminate\Support\Facades\Validator;
use App\Models\VenteProduits\VenteProduits;

class VenteProduitController extends Controller
{
    use cryptTrait, ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Décryptage des données récues
       //$inputs = $this->decryptData($request->p_data);

       //$inputs = $request->p_data;
       $inputs = $request->all();

       // Validation des champs
       $errors = [
           'p_vente'  => 'required',
           'p_details' => 'required'
       ];
       $erreurs = [
           'p_ventes.required' =>'Le montant total est obligatoire',
           'p_details.required' =>'Veuillez selectionner les produits de l\'achat'
       ];

       $validate = Validator::make($inputs, $errors, $erreurs);

       if( $validate->fails()){
           return $this->responseCatchError($validate->errors());
       }else{

           try {
            $date = date('ym');

               //Début de la transaction
               DB::beginTransaction();

               //Insertion des données du client
                $insertionClient = client::create($inputs['p_client']);

                //Insertion des données dans t_ventes
                $inputs['p_vente']['r_reference'] = ($insertionClient->r_i < 9 )? $date.'0'.$insertionClient->r_i : $date.$insertionClient->r_i;
               $insertion = VenteProduits::create($inputs['p_vente']);

               if( $insertion ){

                foreach ($inputs['p_details'] as $value) {
                    //Insertion des données dans t_details_ventes
                    //$value['r_vente'] = $insertion->id;
                    DetailVentes::create([
                        'r_produit' => $value['id'],
                        'r_quantite' => $value['r_quantite'],
                        'r_prix_vente' => $value['r_prix_vente'],
                        'r_sous_total' => $value['r_sous_total'],
                        'r_vente' => $insertion->id,
                        'r_creer_par' => $inputs['p_client']['r_utilisateur'],
                    ]);
                }

                //Mise à jour des stock;
                foreach ($inputs['p_details'] as  $value) {

                    $check = ProduitsVente::find($value['id']);

                    if( $check ){
                        $check->update([
                            'r_stock' => $check->r_stock - $value['r_quantite']
                        ]);
                    }

                }

                DB::commit();

                $response = 'Le Enregistrement effectué avec succès';
                return $this->responseSuccess($response);

               }




               //$response = $this->crypt('Le fournisseur [ '.$insertion->r_nom_fournisseur.' ] à bien été enregistrée');

               //return $this->responseSuccess($response);

           } catch (\Throwable $e) {
               DB::rollback();
               return $this->responseCatchError($e->getMessage());
           }

       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function show(c $c)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function edit(c $c)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, c $c)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function destroy(c $c)
    {
        //
    }

    public function ventes_par_periode($datedebut, $datefin){

        $vente = VenteProduits::whereBetween('created_at', [$datedebut, $datefin] )->get();

        $donnees = $this->responseSuccess('Liste des ventes', $vente);

        //Cryptage des données avant à envoyer au client
        $donneesCryptees = $this->crypt($donnees);
        return $donneesCryptees;

    }

    public function details_ventes(int $idvente){

        $detailsVente = DetailVentes::orderBy('t_details_ventes.created_at', 'DESC')
                                    ->select('t_produitventes.r_nom_produit', 't_details_ventes.*')
                                    ->join('t_produitventes', 't_details_ventes.r_produit', '=', 't_produitventes.id')
                                    ->where('r_vente', $idvente)
                                    ->get();

        return $detailsVente;

    }
}

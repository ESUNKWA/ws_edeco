<?php

namespace App\Http\Controllers\ventes;

use App\Models\crR;
use Illuminate\Http\Request;
use App\Http\Traits\cryptTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\VenteProduits\Fournisseur;
use Illuminate\Support\Facades\Validator;

class FournisseurController extends Controller
{
    use cryptTrait, ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_fournisseurs = Fournisseur::OrderBy('r_nom_fournisseur', 'ASC')->get();

        $donnees = $this->responseSuccess('Liste des fournisseurs', json_decode($liste_fournisseurs));

        //Cryptage des données avant à envoyer au client
        $donneesCryptees = $this->crypt($donnees);

        return $donneesCryptees;
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
        //$crypt = $this->crypt($request->all());
        //return $crypt;
        //Décryptage des données récues

       $inputs = $this->decryptData($request->p_data);
       //return $inputs;

        // Validation des champs
        $errors = [
            'r_ets'  => 'required|unique:t_fournisseurs',
            'r_nom_fournisseur'  => 'required',
            'r_contact' => 'required|unique:t_fournisseurs',
            'r_produit_fourni' => 'required',
            'r_lieu_de_vente' => 'required',
            'r_creer_par' => 'required'
        ];
        $erreurs = [
            'r_ets.required' =>'Le nom de l\'établissement est obligatoire',
            'r_ets.unique' =>'Le nom de l\'établissement existe dejà',
            'r_nom_fournisseur.required' =>'Le nom du fournisseur est obligatoire',
            'r_contact.required' =>'Numéro de téléphone obligatoire',
            'r_contact.unique' =>'Numéro de téléphone dejà existant',
            'r_produit_fourni.required' =>'Veuillez saisir les produits fournis',
            'r_lieu_de_vente.required'  => 'Veuillez préciser le siège du fournisseur',
            'r_creer_par.required'  => 'Utilisateur obligatoire'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            return $this->responseCatchError($validate->errors());
        }else{

            try {

                $insertion = Fournisseur::create($inputs);

                $response = $this->crypt('Le fournisseur [ '.$insertion->r_nom_fournisseur.' ] à bien été enregistrée');

                return $this->responseSuccess($response);

            } catch (\Throwable $e) {
                return $this->responseCatchError($e->getMessage());
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\crR  $crR
     * @return \Illuminate\Http\Response
     */
    public function show(crR $crR)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\crR  $crR
     * @return \Illuminate\Http\Response
     */
    public function edit(crR $crR)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\crR  $crR
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $inputs = $this->decryptData($request->p_data);
       //$inputs = $request->p_data;

       // Validation des champs
       $errors = [
           'r_ets'  => 'required',
           'r_nom_fournisseur'  => 'required',
           'r_contact' => 'required',
           'r_produit_fourni' => 'required',
           'r_lieu_de_vente' => 'required',
           'r_modifier_par' => 'required',
       ];
       $erreurs = [
           'r_ets.required' =>'Le nom de l\'établissement est obligatoire',
           'r_ets.unique' =>'Le nom de l\'établissement existe dejà',
           'r_nom_fournisseur.required' =>'Le nom du fournisseur est obligatoire',
           'r_contact.required' =>'Numéro de téléphone obligatoire',
           'r_contact.unique' =>'Numéro de téléphone dejà existant',
           'r_produit_fourni.required' =>'Veuillez saisir les produits fournis',
           'r_lieu_de_vente.required'  => 'Veuillez préciser le siège du fournisseur',
           'r_modifier_par.required'  => 'Utilisateur obligatoire'
       ];

       $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            $response = [
                '_status' =>0,
                '_result' => $validate->errors()
            ];
            return $response;
        }else{

            $update = Fournisseur::find($id);

            $update->update($inputs);

            $response = $this->crypt($this->responseSuccess('Modification éffectuée avec succès'));

               return $response;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\crR  $crR
     * @return \Illuminate\Http\Response
     */
    public function destroy(crR $crR)
    {
        //
    }
}

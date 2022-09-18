<?php

namespace App\Http\Controllers\ventes;

use App\Models\c;
use Illuminate\Http\Request;
use App\Http\Traits\cryptTrait;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\VenteProduits\AchatArticle;
use App\Models\VenteProduits\ProduitsVente as Produits;
use App\Models\VenteProduits\ProduitsVente;

class ProduitVenteController extends Controller
{
    use cryptTrait, ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_produits = ProduitsVente::OrderBy('r_nom_produit', 'ASC')->get();

        $donnees = $this->responseSuccess('Liste des produits en ventes', json_decode($liste_produits));

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

        //Décryptage des données récues
       $inputs = $this->decryptData($request->p_data);
        //return $inputs;

       // Validation des champs
       $errors = [
           'r_nom_produit'  => 'required|unique:t_produitventes',
           'r_creer_par' => 'required',
       ];
       $erreurs = [
           'r_nom_produit.required' =>'Le nom du produit est obligatoire',
           'r_nom_produit.unique' =>'Le nom du produit existe dejà',
           'r_creer_par.required'  => 'Utilisateur obligatoire',
       ];

       $validate = Validator::make($inputs, $errors, $erreurs);

       if( $validate->fails()){
           return $this->responseCatchError($validate->errors());
       }else{

           try {

               $insertion = ProduitsVente::create($inputs);

               $response = $this->crypt('Le produit [ '.$insertion->r_nom_produit.' ] à bien été enregistrée');

               return $this->responseSuccess($response);

           } catch (\Throwable $e) {
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
    public function update(Request $request, int $id)
    {
        $inputs = $this->decryptData($request->p_data);
       //return $inputs;

       // Validation des champs
       $errors = [
        'r_nom_produit'  => 'required',
        'r_modifier_par' => 'required',
        ];
        $erreurs = [
            'r_nom_produit.required' =>'Le nom du produit est obligatoire',
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

            $update = ProduitsVente::find($id);

            $update->update($inputs);

            /* $response = [
                '_status' => 1,
                '_result' => 'Le produit [ '.$update->r_nom_produit.' ] à bien été modifiée'
            ];
            return response()->json($response, 200); */

            $response = $this->crypt($this->responseSuccess('Modification éffectuée avec succès'));

               return $response;
        }
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

    public function achat_produit( Request $request ){

       //$datacrypt = $this->crypt($request->all());
       //return $datacrypt;
       //Décryptage des données récues
       $inputs = $this->decryptData($request->p_data);
       //return $inputs;

      // Validation des champs
      $errors = [
          'r_produit'  => 'required',
      ];
      $erreurs = [
          'r_produit.required' =>'Le nom du produit est obligatoire'
      ];

      $validate = Validator::make($inputs, $errors, $erreurs);

      if( $validate->fails()){
          return $this->responseCatchError($validate->errors());
      }else{

          try {

            DB::beginTransaction();

              $insertion = AchatArticle::create($inputs);


              $checkProduit = ProduitsVente::find($inputs['r_produit']);

            $checkProduit->update([
                'r_stock' => $inputs['r_quantite'] + $checkProduit->r_stock
            ]);

              $response = $this->crypt('Enregistrement effectué avec succès');

              DB::commit();

              return $this->responseSuccess($response);

          } catch (\Throwable $e) {
            DB::rollBack();
              return $this->responseCatchError($e->getMessage());
          }

      }
    }

    public function list_achat(){
        $liste_produits = DB::table('t_achat_articles')
                            ->select('t_achat_articles.id','t_achat_articles.r_quantite','t_achat_articles.r_prix_achat','t_achat_articles.r_produit','t_achat_articles.r_fournisseur', 't_produitventes.r_nom_produit')
                            ->join('t_produitventes', 't_produitventes.id', '=','t_achat_articles.r_produit')
                            ->get();

        $donnees = $this->responseSuccess('Liste des achats', json_decode($liste_produits));

        //Cryptage des données avant à envoyer au client
        $donneesCryptees = $this->crypt($donnees);

        return $donneesCryptees;
    }

    public function update_achat(Request $request, int $id)
    {
        $inputs = $this->decryptData($request->p_data);
       //return $inputs;

       // Validation des champs
       $errors = [
        'r_produit'  => 'required',
        'r_modifier_par' => 'required',
        ];
        $erreurs = [
            'r_produit.required' =>'Le nom du produit est obligatoire',
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

            $update = AchatArticle::find($id);

            $update->update($inputs);

            /* $response = [
                '_status' => 1,
                '_result' => 'Le produit [ '.$update->r_nom_produit.' ] à bien été modifiée'
            ];
            return response()->json($response, 200); */

            $response = $this->crypt($this->responseSuccess('Modification éffectuée avec succès'));

               return $response;
        }
    }

}

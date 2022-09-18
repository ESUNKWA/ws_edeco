<?php

namespace App\Http\Controllers\metier;

use App\Models\cr;
use Illuminate\Http\Request;
use App\Models\location\client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class clientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $inputs = $request->all();

        $errors = [
            'p_nom'  => 'required',
            'p_prenoms'  => 'required',
            'p_telephone'  => 'required|size:10',
            'p_utilisateur'  => 'required',
        ];

        $erreurs = [
            'p_nom.required' => 'Veuillez saisir le nom du client',
            'p_prenoms.required' => 'Veuillez saisir le prenoms du client',
            'p_telephone.required' => 'Veuillez saisir le numéro de téléphone du client',
            'p_telephone.size' => 'Le format du numéro de téléphone est incorrect',
            'p_utilisateur.required' => 'L\'utilisateur est inconnue'
        ];

        $validator = Validator::make($inputs, $errors, $erreurs);

        if( $validator->fails() ){

            return $validator->errors();

        }else{

            try {
                
                $client = client::findOrfail($inputs['idclient']);

                if( $client !== null){

                    $client->update([
                        'r_nom' => $request->p_nom,
                        'r_prenoms' => $request->p_prenoms,
                        'r_telephone' => '225'.$request->p_telephone,
                        'r_email' => $request->p_email,
                        'r_description' => $request->p_description,
                        'r_utilisateur' => $request->p_utilisateur,
                    ]);

                    if ($client) {

                        $response = [
                            '_status' => 1,
                            '_result' => "Modification effectuée avec succès"
                        ];
                        
                    }else{
                        $response = [
                            '_status' => 0,
                            '_result' => "Une erreur est survenue lors de la modification, veuillez contacter l'administrateur"
                        ];
                    }

                    return response()->json($response, 200);
                }

            } catch (\Throwable $e) {
               return $e->getMessage(). "\n";
            }
        }

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
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
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

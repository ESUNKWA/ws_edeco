<?php

namespace App\Http\Controllers\metier;

use App\Models\cr;
use Illuminate\Http\Request;
use App\Models\metier\Communes;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class communesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listeCommunes = DB::select('select r_i as value, r_libelle as label, created_at from t_communes order by r_libelle');
        $response = [
            '_status' => 1,
            '_result' => $listeCommunes
        ];
        return response()->json($response, 200);
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
        
        // Validation des champs
        $errors = [
            'r_libelle'  => 'required|unique:t_communes',
            'p_utilisateur' => 'required'
        ];
        $erreurs = [
            'r_libelle.required' =>'Le libellé est obligatoire',
            'r_libelle.unique' =>'Commune déjà existant',
            'p_utilisateur.required'  => 'Veuillez préciser l\'utilisateur'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            $response = [
                '_status' =>-100,
                '_result' => $validate->errors()
            ];
            return $response;
        }else{
          
            $insertion = Communes::create([
                'r_libelle' => $request->r_libelle,
                'r_description' => $request->p_description,
                'r_utilisateur' => $request->p_utilisateur,
                'r_status' => 1,
                'r_situation_geo' => $request->p_situation_geo,
            ]);

            $response = [
                '_status' => 1,
                //'_result' => 'La Commune [ '.$insertion->r_libelle.' ] à bien été enregistrée'
                '_result' => $insertion
            ];
            return response()->json($response, 200);
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
        
        // Validation des champs
        $errors = [
            'r_libelle'  => 'required',
            'p_utilisateur' => 'required'
        ];
        $erreurs = [
            'r_libelle.required' =>'Le libellé est obligatoire',
            'p_utilisateur.required'  => 'Veuillez préciser l\'utilisateur'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            $response = [
                '_status' =>-100,
                '_result' => $validate->errors()
            ];
            return $response;
        }else{
          $update = Communes::find($id);
          
          if( $update !== null ){
              
                $update->update([
                    'r_libelle'         => $request->r_libelle,
                    'r_description'     => $request->p_description,
                    'r_utilisateur'     => $request->p_utilisateur,
                    'r_status'          => $request->p_status,
                    'r_situation_geo'   => $request->p_situation_geo,
                ]);

                $response = [
                    '_status' => 1,
                    '_result' => 'Modification effectuée avec succès'
                ];
               
          }else{

                $response = [
                    '_status' => 1,
                    '_result' => 'Modification effectuée avec succès'
                ];
            
          }
                $response = [
                    '_status' => 1,
                    '_result' => 'Modification effectuée avec succès'
                ];
                return response()->json($response, 200);
        }
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

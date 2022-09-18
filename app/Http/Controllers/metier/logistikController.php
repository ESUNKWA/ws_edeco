<?php

namespace App\Http\Controllers\metier;

use App\Models\cr;
use Illuminate\Http\Request;
use App\Models\metier\Logistik;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class logistikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listeLogistk = DB::select('select r_i as value, r_vehicule as label, r_matricule from t_logistiques order by r_vehicule asc');
        $response = [
            '_status' => 1,
            '_result' => $listeLogistk
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
            'r_matricule'  => 'required|unique:t_logistiques',
            'p_vehicule'  => 'required',
            'p_utilisateur' => 'required'
        ];
        $erreurs = [
            'r_matricule.required' =>'Le matricule est obligatoire',
            'r_matricule.unique' =>'Matricule déjà existant',
            'p_vehicule.required' =>'Le Matricule est obligatoire',
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
          
            $insertion = Logistik::create([
                'r_matricule' => $request->r_matricule,
                'r_vehicule' => $request->p_vehicule,
                'r_description' => $request->p_description,
                'r_utilisateur' => 1,
                'r_status' => $request->p_status,
                'r_utilisateur' => $request->p_utilisateur
            ]);

            $response = [
                '_status' => 1,
                '_result' => 'La véhicule [ '.$insertion->r_matricule.' ] à bien été enregistrée'
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
            'r_matricule'  => 'required',
            'p_vehicule'  => 'required',
            'p_utilisateur' => 'required'
        ];
        $erreurs = [
            'r_matricule.required' =>'Le matricule est obligatoire',
            //'r_matricule.unique' =>'Matricule déjà existant',
            'p_vehicule.required' =>'Le Matricule est obligatoire',
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
            $update = Logistik::find($id);

            if( $update !== null ){
            
                $update->update([
                    //'r_matricule' => $request->r_matricule,
                    'r_vehicule' => $request->p_vehicule,
                    'r_description' => $request->p_description,
                    'r_utilisateur' => 1,
                    'r_status' => $request->p_status,
                    'r_utilisateur' => $request->p_utilisateur
                ]);
    
                $response = [
                    '_status' => 1,
                    '_result' => 'MOdification effectuée avec succès'
                ];
            }
            
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

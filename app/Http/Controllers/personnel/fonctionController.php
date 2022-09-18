<?php

namespace App\Http\Controllers\personnel;

use App\Models\cr;
use Illuminate\Http\Request;
use App\Models\personnel\Fonction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class fonctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_fonctions = DB::table('t_fonctions')
        ->select('t_fonctions.r_i as value','t_fonctions.r_libelle as label')
        ->get();
        $datas = [
            '_status' => 1,
            '_result' => $liste_fonctions
        ];
        return $datas;
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
            'r_libelle'  => 'required|unique:t_categories',
            'p_utilisateur' => 'required'
        ];
        $erreurs = [
            'r_libelle.required' =>'Le libellé est obligatoire',
            'r_libelle.unique' =>'Catégories déjà existant',
            'p_utilisateur.required'  => 'Veuillez préciser l\'utilisateur'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            return $validate->errors();
        }else{
            $insertion = Fonction::create([
                'r_libelle' => $request->r_libelle,
                'r_description' => $request->p_description,
                'r_utilisateur' => $request->p_utilisateur
            ]);

            $response = [
                '_status' => 1,
                '_result' => 'La fonction [ '.$insertion->r_libelle.' ] à bien été enregistrée'
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
